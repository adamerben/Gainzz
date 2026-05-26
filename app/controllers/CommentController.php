<?php

class CommentController
{

    // Pomocná metoda pro kontrolu práv admina
    private function checkAdmin()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['messages']['error'][] = 'K této akci nemáte dostatečná oprávnění.';
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $exerciseId = (int) ($_POST['exercise_id'] ?? 0);
            $target = $exerciseId > 0 ? BASE_URL . '/index.php?url=exercise/show/' . $exerciseId : BASE_URL . '/index.php';
            header('Location: ' . $target);
            exit;
        }

        if (!isset($_SESSION['user_id'])) {
            $_SESSION['messages']['error'][] = 'Pro vložení komentáře se musíte nejprve přihlásit.';
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        $exerciseId = (int) ($_POST['exercise_id'] ?? 0);
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
// UPRAVENÁ METODA PRO SMAZÁNÍ KOMENTÁŘE (Může smazat autor i admin)
    public function delete($id)
    {
        // Kontrola, zda je uživatel vůbec přihlášený
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Comment.php';

        $database = new Database();
        $db = $database->getConnection();
        $commentModel = new Comment($db);

        // Najdeme komentář, abychom znali jeho autora a ID cviku pro přesměrování
        $comment = $commentModel->getById((int) $id);

        if (!$comment) {
            $_SESSION['messages']['error'][] = 'Komentář nebyl nalezen.';
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // KONTROLA PRÁV: Je to můj komentář? Nebo jsem admin?
        if ($_SESSION['user_id'] != $comment['user_id'] && $_SESSION['user_role'] !== 'admin') {
            $_SESSION['messages']['error'][] = 'Nemáte oprávnění smazat tento komentář.';
            header('Location: ' . BASE_URL . '/index.php?url=exercise/show/' . $comment['exercise_id']);
            exit;
        }

        $exerciseId = $comment['exercise_id'];

        if ($commentModel->delete((int) $id)) {
            $_SESSION['messages']['success'][] = 'Komentář byl úspěšně odstraněn.';
        } else {
            $_SESSION['messages']['error'][] = 'Chyba při mazání komentáře.';
        }

        header('Location: ' . BASE_URL . '/index.php?url=exercise/show/' . $exerciseId);
        exit;
    }

    public function edit($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
        require_once '../app/models/Database.php';
        require_once '../app/models/Comment.php';
        $db = (new Database())->getConnection();
        $commentModel = new Comment($db);
        $comment = $commentModel->getById((int) $id);

        // Kontrola, zda komentář existuje a zda patří přihlášenému uživateli (nebo je admin)
        if (!$comment || ($_SESSION['user_id'] != $comment['user_id'] && $_SESSION['user_role'] !== 'admin')) {
            $_SESSION['messages']['error'][] = 'Nemáte oprávnění upravovat tento komentář.';
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
        require_once '../app/views/comments/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once '../app/models/Database.php';
            require_once '../app/models/Comment.php';
            $db = (new Database())->getConnection();
            $commentModel = new Comment($db);

            $comment = $commentModel->getById((int) $id);
            $content = trim(htmlspecialchars($_POST['content'] ?? ''));

            if ($comment && ($_SESSION['user_id'] == $comment['user_id'] || $_SESSION['user_role'] === 'admin') && $content !== '') {
                $commentModel->update((int) $id, $content);
                $_SESSION['messages']['success'][] = 'Komentář byl upraven.';
                header('Location: ' . BASE_URL . '/index.php?url=exercise/show/' . $comment['exercise_id']);
            } else {
                $_SESSION['messages']['error'][] = 'Chyba při úpravě komentáře.';
                header('Location: ' . BASE_URL . '/index.php?url=comment/edit/' . $id);
            }
            exit;
        }
    }
}