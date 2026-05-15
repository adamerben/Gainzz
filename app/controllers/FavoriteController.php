<?php
class FavoriteController {
    public function toggle($exerciseId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Favorite.php';
        
        $db = (new Database())->getConnection();
        $favoriteModel = new Favorite($db);
        $userId = $_SESSION['user_id'];

        if ($favoriteModel->isFavorite($userId, $exerciseId)) {
            $favoriteModel->remove($userId, $exerciseId);
            $_SESSION['messages']['notice'][] = 'Cvik byl odebrán z oblíbených.';
        } else {
            $favoriteModel->add($userId, $exerciseId);
            $_SESSION['messages']['success'][] = 'Cvik byl přidán do tvého tréninku! 💪';
        }

        header('Location: ' . BASE_URL . '/index.php?url=exercise/show/' . $exerciseId);
        exit;
    }
}