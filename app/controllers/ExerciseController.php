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

    // Pomocná metoda pro kontrolu práv admina
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
        require_once '../app/views/exercises/exercise_show.php';
    }

    public function create() {
        $this->checkAdmin(); // Pouze pro adminy
        $muscleGroups = $this->muscleGroupModel->getAll();
        require_once '../app/views/exercises/exercise_create.php';
    }

    public function store() {
        $this->checkAdmin(); // Pouze pro adminy
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'muscle_group_id' => $_POST['muscle_group_id'],
                'equipment' => $_POST['equipment'],
                'difficulty' => $_POST['difficulty'],
                'description' => trim($_POST['description']),
                'video_link' => trim($_POST['video_link'] ?? '')
            ];

            $image_path = $this->handleImageUpload($_FILES['image']);
            $data['image_path'] = $image_path;

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
        $this->checkAdmin(); // Pouze pro adminy
        $exercise = $this->exerciseModel->getById($id);
        $muscleGroups = $this->muscleGroupModel->getAll();
        require_once '../app/views/exercises/exercise_edit.php';
    }

    public function update($id) {
        $this->checkAdmin(); // Pouze pro adminy
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => trim($_POST['title']),
                'muscle_group_id' => $_POST['muscle_group_id'],
                'equipment' => $_POST['equipment'],
                'difficulty' => $_POST['difficulty'],
                'description' => trim($_POST['description']),
                'video_link' => trim($_POST['video_link'] ?? '')
            ];

            if (!empty($_FILES['image']['name'])) {
                $data['image_path'] = $this->handleImageUpload($_FILES['image']);
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
        $this->checkAdmin(); // Pouze pro adminy
        if ($this->exerciseModel->delete($id)) {
            $_SESSION['messages']['success'][] = 'Cvik byl smazán.';
        } else {
            $_SESSION['messages']['error'][] = 'Chyba při mazání cviku.';
        }
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    private function handleImageUpload($file) {
        if (empty($file['name'])) return null;
        $targetDir = "../public/uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = uniqid() . "_" . basename($file["name"]);
        $targetFile = $targetDir . $fileName;
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return "uploads/" . $fileName;
        }
        return null;
    }
}