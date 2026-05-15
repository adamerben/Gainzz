<?php

class UserController {
    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro zobrazení profilu se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/User.php';

        $database = new Database();
        $db = $database->getConnection();

        $userModel = new User($db);
        $user = $userModel->getById($_SESSION['user_id']);

        if (!$user) {
            $this->addErrorMessage('Uživatel nebyl nalezen.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Pod načtení usera přidej:
        require_once '../app/models/Favorite.php';
        $favoriteModel = new Favorite($db);
        $favoriteExercises = $favoriteModel->getByUserId($_SESSION['user_id']);

        // Výpočet BMI
        $bmi = null;
        $bmiCategory = null;
        if ($user['weight'] && $user['height']) {
            $heightInMeters = $user['height'] / 100;
            $bmi = round($user['weight'] / ($heightInMeters * $heightInMeters), 1);

            if ($bmi < 18.5) {
                $bmiCategory = 'Podváha';
            } elseif ($bmi < 25) {
                $bmiCategory = 'Normální';
            } elseif ($bmi < 30) {
                $bmiCategory = 'Nadváha';
            } else {
                $bmiCategory = 'Obezita';
            }
        }

        require_once '../app/views/users/profile.php';
    }

    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro úpravu profilu se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->addNoticeMessage('Formulář nebyl odeslán.');
            header('Location: ' . BASE_URL . '/index.php?url=user/profile');
            exit;
        }

        $weight = (float)($_POST['weight'] ?? 0);
        $height = (int)($_POST['height'] ?? 0);
        $bio = trim(htmlspecialchars($_POST['bio'] ?? ''));

        $errors = [];

        if ($weight <= 0) {
            $errors[] = 'Váha musí být větší než 0.';
        }
        if ($height <= 0) {
            $errors[] = 'Výška musí být větší než 0.';
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->addErrorMessage($error);
            }
            header('Location: ' . BASE_URL . '/index.php?url=user/profile');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/User.php';

        $database = new Database();
        $db = $database->getConnection();

        $userModel = new User($db);

        $data = [
            'weight' => $weight,
            'height' => $height,
            'bio' => $bio,
        ];

        $isUpdated = $userModel->updateProfile($_SESSION['user_id'], $data);

        if ($isUpdated) {
            $this->addSuccessMessage('Profil byl úspěšně aktualizován.');
        } else {
            $this->addErrorMessage('Nastala chyba při aktualizaci profilu.');
        }

        header('Location: ' . BASE_URL . '/index.php?url=user/profile');
        exit;
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
