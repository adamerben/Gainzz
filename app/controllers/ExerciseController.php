<?php

class ExerciseController {
    public function index() {
        require_once '../app/models/Database.php';
        require_once '../app/models/Exercise.php';

        $database = new Database();
        $db = $database->getConnection();

        $exerciseModel = new Exercise($db);
        $exercises = $exerciseModel->getAll();

        require_once '../app/views/exercises/exercises_list.php';
    }

    public function show($id = null) {
        if (!$id) {
            $this->addErrorMessage('Nebyl zvolen konkrétní cvik.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Exercise.php';

        $database = new Database();
        $db = $database->getConnection();

        $exerciseModel = new Exercise($db);
        $exercise = $exerciseModel->getById((int)$id);

        if (!$exercise) {
            $this->addErrorMessage('Cvik nebyl nalezen.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/views/exercises/exercise_show.php';
    }

    public function create() {
        require_once '../app/models/Database.php';
        require_once '../app/models/MuscleGroup.php';

        $database = new Database();
        $db = $database->getConnection();

        $muscleGroupModel = new MuscleGroup($db);
        $muscleGroups = $muscleGroupModel->getAll();

        require_once '../app/views/exercises/exercise_create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->addNoticeMessage('Formulář nebyl odeslán.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $title = trim(htmlspecialchars($_POST['title'] ?? ''));
        $muscleGroupId = (int)($_POST['muscle_group_id'] ?? 0);
        $equipment = trim(htmlspecialchars($_POST['equipment'] ?? ''));
        $difficulty = trim(htmlspecialchars($_POST['difficulty'] ?? ''));
        $description = trim(htmlspecialchars($_POST['description'] ?? ''));
        $videoLink = trim(htmlspecialchars($_POST['video_link'] ?? '')) ?: null;

        $errors = [];

        if ($title === '') {
            $errors[] = 'Název cviku je povinný.';
        }
        if ($muscleGroupId <= 0) {
            $errors[] = 'Musí být vybrána svalová partie.';
        }
        if ($equipment === '') {
            $errors[] = 'Pole vybavení je povinné.';
        }
        if ($difficulty === '') {
            $errors[] = 'Pole obtížnosti je povinné.';
        }
        if ($description === '') {
            $errors[] = 'Popis cviku je povinný.';
        }

        $imagePath = $this->handleImageUpload($_FILES['image'] ?? null);

        if ($imagePath === false) {
            $errors[] = 'Nahrání obrázku se nezdařilo. Použijte prosím soubor JPG, PNG nebo GIF.';
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->addErrorMessage($error);
            }
            header('Location: ' . BASE_URL . '/index.php?url=exercise/create');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Exercise.php';

        $database = new Database();
        $db = $database->getConnection();

        $exerciseModel = new Exercise($db);

        $isSaved = $exerciseModel->create(
            $title,
            $muscleGroupId,
            $equipment,
            $difficulty,
            $description,
            $imagePath,
            $videoLink
        );

        if ($isSaved) {
            $this->addSuccessMessage('Cvik byl uložen.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $this->addErrorMessage('Nastala chyba při ukládání cviku.');
        header('Location: ' . BASE_URL . '/index.php?url=exercise/create');
        exit;
    }

    public function edit($id = null) {
        if (!$id) {
            $this->addErrorMessage('Nebyl zvolen cvik k úpravě.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Exercise.php';
        require_once '../app/models/MuscleGroup.php';

        $database = new Database();
        $db = $database->getConnection();

        $exerciseModel = new Exercise($db);
        $exercise = $exerciseModel->getById((int)$id);

        if (!$exercise) {
            $this->addErrorMessage('Cvik se nenašel.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $muscleGroupModel = new MuscleGroup($db);
        $muscleGroups = $muscleGroupModel->getAll();

        require_once '../app/views/exercises/exercise_edit.php';
    }

    public function update($id = null) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
            $this->addNoticeMessage('Formulář nebyl odeslán správně.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $title = trim(htmlspecialchars($_POST['title'] ?? ''));
        $muscleGroupId = (int)($_POST['muscle_group_id'] ?? 0);
        $equipment = trim(htmlspecialchars($_POST['equipment'] ?? ''));
        $difficulty = trim(htmlspecialchars($_POST['difficulty'] ?? ''));
        $description = trim(htmlspecialchars($_POST['description'] ?? ''));
        $videoLink = trim(htmlspecialchars($_POST['video_link'] ?? '')) ?: null;

        $errors = [];

        if ($title === '') {
            $errors[] = 'Název cviku je povinný.';
        }
        if ($muscleGroupId <= 0) {
            $errors[] = 'Musí být vybrána svalová partie.';
        }
        if ($equipment === '') {
            $errors[] = 'Pole vybavení je povinné.';
        }
        if ($difficulty === '') {
            $errors[] = 'Pole obtížnosti je povinné.';
        }
        if ($description === '') {
            $errors[] = 'Popis cviku je povinný.';
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Exercise.php';

        $database = new Database();
        $db = $database->getConnection();

        $exerciseModel = new Exercise($db);
        $exercise = $exerciseModel->getById((int)$id);

        if (!$exercise) {
            $this->addErrorMessage('Cvik nebyl nalezen.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $imagePath = $exercise['image_path'];
        $uploadResult = $this->handleImageUpload($_FILES['image'] ?? null);
        if ($uploadResult === false) {
            $errors[] = 'Nahrání obrázku se nezdařilo. Použijte prosím soubor JPG, PNG nebo GIF.';
        } elseif ($uploadResult !== null) {
            $imagePath = $uploadResult;
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->addErrorMessage($error);
            }
            header('Location: ' . BASE_URL . '/index.php?url=exercise/edit/' . (int)$id);
            exit;
        }

        $isUpdated = $exerciseModel->update(
            (int)$id,
            $title,
            $muscleGroupId,
            $equipment,
            $difficulty,
            $description,
            $imagePath,
            $videoLink
        );

        if ($isUpdated) {
            $this->addSuccessMessage('Cvik byl aktualizován.');
            header('Location: ' . BASE_URL . '/index.php?url=exercise/show/' . (int)$id);
            exit;
        }

        $this->addErrorMessage('Nastala chyba při aktualizaci cviku.');
        header('Location: ' . BASE_URL . '/index.php?url=exercise/edit/' . (int)$id);
        exit;
    }

    public function delete($id = null) {
        if (!$id) {
            $this->addErrorMessage('Nebyl zvolen cvik ke smazání.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Exercise.php';

        $database = new Database();
        $db = $database->getConnection();

        $exerciseModel = new Exercise($db);
        $isDeleted = $exerciseModel->delete((int)$id);

        if ($isDeleted) {
            $this->addSuccessMessage('Cvik byl smazán.');
        } else {
            $this->addErrorMessage('Nastala chyba při mazání cviku.');
        }

        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    private function handleImageUpload($file) {
        if (empty($file) || !isset($file['tmp_name']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
        ];

        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $file['tmp_name']);
        finfo_close($fileInfo);

        if (!array_key_exists($mimeType, $allowedTypes)) {
            return false;
        }

        $uploadDir = realpath(__DIR__ . '/../../public/uploads');
        if ($uploadDir === false) {
            return false;
        }

        $extension = $allowedTypes[$mimeType];
        $newName = 'exercise_' . time() . '_' . bin2hex(random_bytes(5)) . '.' . $extension;
        $destination = $uploadDir . DIRECTORY_SEPARATOR . $newName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return false;
        }

        return 'uploads/' . $newName;
    }

    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
    }

    protected function addNoticeMessage($message) {
        $_SESSION['messages']['notice'][] = $message;
    }

    protected function addErrorMessage($message) {
        $_SESSION['messages']['error'][] = $message;
    }
}
