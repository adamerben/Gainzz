<?php

class AuthController
{

    public function login()
    {
        require_once '../app/views/auth/login.php';
    }

    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            require_once '../app/models/Database.php';
            require_once '../app/models/User.php';

            $db = (new Database())->getConnection();
            $userModel = new User($db);

            // Hledáme uživatele podle emailu
            $user = $userModel->findByEmail($email);

            // Ověření hesla
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['username'];
                $_SESSION['user_role'] = $user['role'];

                $_SESSION['messages']['success'][] = 'Úspěšně přihlášen!';
                header('Location: ' . BASE_URL . '/index.php');
            } else {
                $_SESSION['messages']['error'][] = 'Špatný email nebo heslo.';
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            }
            exit;
        }
    }

    public function register()
    {
        require_once '../app/views/auth/register.php';
    }

    public function storeUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $errors = [];

            // 1. Kontrola, zda jsou pole vyplněná
            if (empty($username) || empty($email) || empty($password)) {
                $errors[] = 'Vyplňte všechna povinná pole.';
            }

            // 2. KONTROLA SÍLY HESLA (Učitelův požadavek)
            if (strlen($password) < 8) {
                $errors[] = 'Heslo musí mít alespoň 8 znaků.';
            }
            if (!preg_match('/[A-Z]/', $password)) {
                $errors[] = 'Heslo musí obsahovat alespoň jedno velké písmeno.';
            }
            if (!preg_match('/[a-z]/', $password)) {
                $errors[] = 'Heslo musí obsahovat alespoň jedno malé písmeno.';
            }
            if (!preg_match('/[0-9]/', $password)) {
                $errors[] = 'Heslo musí obsahovat alespoň jednu číslici.';
            }
            if (!preg_match('/[\W_]/', $password)) { // \W znamená jakýkoliv ne-alfanumerický znak
                $errors[] = 'Heslo musí obsahovat alespoň jeden speciální znak (např. !@#$%^&*).';
            }

            // Pokud se nasbíraly nějaké chyby, vrátíme uživatele zpět s výpisem chyb
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $_SESSION['messages']['error'][] = $error;
                }
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            // Pokud je vše v pořádku, uložíme do databáze
            require_once '../app/models/Database.php';
            require_once '../app/models/User.php';

            $db = (new Database())->getConnection();
            $userModel = new User($db);

            if ($userModel->register($username, $email, $password)) {
                $_SESSION['messages']['success'][] = 'Registrace byla úspěšná! Nyní se přihlaste.';
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            } else {
                $_SESSION['messages']['error'][] = 'Tento email už se používá.';
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
            }
            exit;
        }
    }

    public function logout()
    {
        session_destroy();
        session_start();
        $_SESSION['messages']['success'][] = 'Byli jste odhlášeni.';
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }
}