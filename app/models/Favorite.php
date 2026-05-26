<?php
class Favorite
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function add($userId, $exerciseId)
    {
        $sql = "INSERT IGNORE INTO favorites (user_id, exercise_id) VALUES (:user_id, :exercise_id)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':user_id' => $userId, ':exercise_id' => $exerciseId]);
    }

    public function remove($userId, $exerciseId)
    {
        $sql = "DELETE FROM favorites WHERE user_id = :user_id AND exercise_id = :exercise_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':user_id' => $userId, ':exercise_id' => $exerciseId]);
    }

    public function isFavorite($userId, $exerciseId)
    {
        $sql = "SELECT id FROM favorites WHERE user_id = :user_id AND exercise_id = :exercise_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId, ':exercise_id' => $exerciseId]);
        return $stmt->fetch() ? true : false;
    }

    public function getByUserId($userId)
    {
        $sql = "SELECT exercises.*, muscle_groups.name AS muscle_group_name 
                FROM exercises 
                JOIN favorites ON exercises.id = favorites.exercise_id 
                LEFT JOIN muscle_groups ON exercises.muscle_group_id = muscle_groups.id
                WHERE favorites.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}