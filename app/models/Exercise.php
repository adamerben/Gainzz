<?php

class Exercise {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAll() {
        $sql = "SELECT exercises.*, muscle_groups.name AS muscle_group_name
"
             . "FROM exercises
"
             . "LEFT JOIN muscle_groups ON exercises.muscle_group_id = muscle_groups.id
"
             . "ORDER BY exercises.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id) {
        $sql = "SELECT exercises.*, muscle_groups.name AS muscle_group_name
"
             . "FROM exercises
"
             . "LEFT JOIN muscle_groups ON exercises.muscle_group_id = muscle_groups.id
"
             . "WHERE exercises.id = :id
"
             . "LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(
        string $title,
        int $muscleGroupId,
        string $equipment,
        string $difficulty,
        string $description,
        ?string $imagePath,
        ?string $videoLink
    ): bool {
        $sql = "INSERT INTO exercises (title, muscle_group_id, equipment, difficulty, description, image_path, video_link)"
             . " VALUES (:title, :muscle_group_id, :equipment, :difficulty, :description, :image_path, :video_link)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title' => $title,
            ':muscle_group_id' => $muscleGroupId,
            ':equipment' => $equipment,
            ':difficulty' => $difficulty,
            ':description' => $description,
            ':image_path' => $imagePath,
            ':video_link' => $videoLink,
        ]);
    }

    public function update(
        int $id,
        string $title,
        int $muscleGroupId,
        string $equipment,
        string $difficulty,
        string $description,
        ?string $imagePath,
        ?string $videoLink
    ): bool {
        $sql = "UPDATE exercises SET title = :title, muscle_group_id = :muscle_group_id, equipment = :equipment, difficulty = :difficulty, description = :description, image_path = :image_path, video_link = :video_link WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':muscle_group_id' => $muscleGroupId,
            ':equipment' => $equipment,
            ':difficulty' => $difficulty,
            ':description' => $description,
            ':image_path' => $imagePath,
            ':video_link' => $videoLink,
        ]);
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM exercises WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}
