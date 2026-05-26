<?php

class CommentController {
    
    // Pomocná metoda pro kontrolu práv admina
    private function checkAdmin() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['messages']['error'][] = 'K této akci nemáte dostatečná oprávnění.';
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $exerciseId = (int)($_POST['exercise_id'] ?? 0);
            $target = $exerciseId > 0 ? BASE_URL . '/index.php?url=exercise/show/' . $exerciseId : BASE_URL . '/index.php';
            header('Location: ' . $target);
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['messages']['error'][] = 'Pro vložení komentáře se musíte nejprve přihlásit.';
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        $exerciseId = (int)($_POST['exercise_id'] ?? 0);
        $content = trim(htmlspecialchars($_POST['content'] ?? ''));

        $redirectUrl = BASE_URL . '/index.php?url=exercise/show/' . $exerciseId;

        if ($exerciseId <= 0 || $content === '') {
            if ($exerciseId <= 0) {
                $_SESSION['messages']['error'][] = 'Nebyl určen platný cvik.';
            }
            if ($content === '') {
                $_SESSION['messages']['error'][] = 'Komentář nesmí být prázdný.';
            }
            header('Location: ' . $redirectUrl);
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Comment.php';

        $database = new Database();
        $db = $database->getConnection();

        $commentModel = new Comment($db);
        $isSaved = $commentModel->add([
            'exercise_id' => $exerciseId,
            'user_id' => $_SESSION['user_id'],
            'content' => $content,
        ]);

        if ($isSaved) {
            $_SESSION['messages']['success'][] = 'Komentář byl úspěšně přidán.';
        } else {
            $_SESSION['messages']['error'][] = 'Komentář se nepodařilo uložit. Zkuste to prosím znovu.';
        }

        header('Location: ' . $redirectUrl);
        exit;
    }

    // NOVÁ METODA PRO SMAZÁNÍ KOMENTÁŘE
    public function delete($id) {
        $this->checkAdmin(); // Pouze admin smí mazat

        require_once '../app/models/Database.php';
        require_once '../app/models/Comment.php';

        $database = new Database();
        $db = $database->getConnection();
        $commentModel = new Comment($db);

        // Najdeme komentář, abychom věděli, na jaký cvik se po smazání vrátit
        $comment = $commentModel->getById((int)$id);
        
        if (!$comment) {
            $_SESSION['messages']['error'][] = 'Komentář nebyl nalezen.';
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $exerciseId = $comment['exercise_id'];

        if ($commentModel->delete((int)$id)) {
            $_SESSION['messages']['success'][] = 'Komentář byl úspěšně odstraněn.';
        } else {
            $_SESSION['messages']['error'][] = 'Chyba při mazání komentáře.';
        }

        header('Location: ' . BASE_URL . '/index.php?url=exercise/show/' . $exerciseId);
        exit;
    }
}