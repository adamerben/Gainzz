<?php

class ExerciseController {
    private $db;
    private $exerciseModel;
    private $muscleGroupModel;

    public function __construct() {
        require_once '../app/models/Database.php';
        require_once '../app/models/Exercise.php';
        require_once '../app/models/MuscleGroup.php';

        $database = new Database();
        $this->db = $database->getConnection();
        $this->exerciseModel = new Exercise($this->db);
        $this->muscleGroupModel = new MuscleGroup($this->db);
    }

    private function checkAdmin() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['messages']['error'][] = 'K této akci nemáte dostatečná oprávnění.';
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
    }

    public function index() {
        $exercises = $this->exerciseModel->getAll();
        require_once '../app/views/exercises/exercises_list.php';
    }

    public function show($id) {
        $exercise = $this->exerciseModel->getById($id);
        if (!$exercise) {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Comment.php'; 
        $commentModel = new Comment($this->db);
        $comments = $commentModel->getByExerciseId($id);

        require_once '../app/models/Favorite.php';
        $favoriteModel = new Favorite($this->db);
        $isFavorite = false;
        
        if (isset($_SESSION['user_id'])) {
            $isFavorite = $favoriteModel->isFavorite($_SESSION['user_id'], $id);
        }

        require_once '../app/views/exercises/exercise_show.php';
    }

    public function create() {
        $this->checkAdmin();
        $muscleGroups = $this->muscleGroupModel->getAll();
        require_once '../app/views/exercises/exercise_create.php';
    }

    public function store() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'muscle_group_id' => (int)($_POST['muscle_group_id'] ?? 0),
                'equipment' => trim($_POST['equipment'] ?? ''),
                'difficulty' => trim($_POST['difficulty'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'video_link' => trim($_POST['video_link'] ?? '')
            ];

            // Nahrání obrázku - pokud existuje a není prázdný
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image_path'] = $this->handleImageUpload($_FILES['image']);
            } else {
                $data['image_path'] = null;
            }

            if ($this->exerciseModel->create($data)) {
                $_SESSION['messages']['success'][] = 'Cvik byl úspěšně přidán.';
                header('Location: ' . BASE_URL . '/index.php');
            } else {
                $_SESSION['messages']['error'][] = 'Chyba při ukládání cviku.';
                header('Location: ' . BASE_URL . '/index.php?url=exercise/create');
            }
            exit;
        }
    }

    public function edit($id) {
        $this->checkAdmin();
        $exercise = $this->exerciseModel->getById($id);
        $muscleGroups = $this->muscleGroupModel->getAll();
        require_once '../app/views/exercises/exercise_edit.php';
    }

    public function update($id) {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title'] ?? ''),
                'muscle_group_id' => (int)($_POST['muscle_group_id'] ?? 0),
                'equipment' => trim($_POST['equipment'] ?? ''),
                'difficulty' => trim($_POST['difficulty'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'video_link' => trim($_POST['video_link'] ?? '')
            ];

            // Nahrání NOVÉHO obrázku - jen pokud uživatel nějaký vybral
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadedPath = $this->handleImageUpload($_FILES['image']);
                if ($uploadedPath) {
                    $data['image_path'] = $uploadedPath;
                }
            }

            if ($this->exerciseModel->update($id, $data)) {
                $_SESSION['messages']['success'][] = 'Cvik byl úspěšně aktualizován.';
                header('Location: ' . BASE_URL . '/index.php?url=exercise/show/' . $id);
            } else {
                $_SESSION['messages']['error'][] = 'Chyba při aktualizaci cviku.';
                header('Location: ' . BASE_URL . '/index.php?url=exercise/edit/' . $id);
            }
            exit;
        }
    }

    public function delete($id) {
        $this->checkAdmin();
        if ($this->exerciseModel->delete($id)) {
            $_SESSION['messages']['success'][] = 'Cvik byl smazán.';
        } else {
            $_SESSION['messages']['error'][] = 'Chyba při mazání cviku.';
        }
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    private function handleImageUpload($file) {
        // Kontrola jestli vůbec nějaký soubor reálně dorazil
        if (!isset($file['name']) || empty($file['name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Absolutní cesta k public/uploads (bezpečné odkudkoliv)
        $targetDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Vyčištění názvu souboru (zbaví se mezer a češtiny, které servery nesnáší)
        $safeFileName = preg_replace("/[^a-zA-Z0-9.]/", "_", basename($file["name"]));
        $fileName = uniqid() . "_" . $safeFileName;
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return "uploads/" . $fileName;
        }
        
        return null;
    }
}