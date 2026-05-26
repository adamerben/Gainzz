<?php

class Comment {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getByExerciseId(int $exerciseId) {
        $sql = "SELECT comments.*, users.username AS author_name\n"
             . "FROM comments\n"
             . "LEFT JOIN users ON comments.user_id = users.id\n"
             . "WHERE comments.exercise_id = :exercise_id\n"
             . "ORDER BY comments.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':exercise_id' => $exerciseId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add(array $data): bool {
        $sql = "INSERT INTO comments (exercise_id, user_id, content, created_at)"
             . " VALUES (:exercise_id, :user_id, :content, :created_at)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':exercise_id' => (int)$data['exercise_id'],
            ':user_id' => (int)$data['user_id'],
            ':content' => $data['content'],
            ':created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    // Vyhledání jednoho komentáře podle ID (potřebné pro přesměrování)
    public function getById(int $id) {
        $sql = "SELECT * FROM comments WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Smazání komentáře z databáze
    public function delete(int $id): bool {
        $sql = "DELETE FROM comments WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
