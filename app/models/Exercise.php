<?php

class Exercise
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $sql = "SELECT exercises.*, muscle_groups.name AS muscle_group_name "
            . "FROM exercises "
            . "LEFT JOIN muscle_groups ON exercises.muscle_group_id = muscle_groups.id "
            . "ORDER BY exercises.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id)
    {
        $sql = "SELECT exercises.*, muscle_groups.name AS muscle_group_name "
            . "FROM exercises "
            . "LEFT JOIN muscle_groups ON exercises.muscle_group_id = muscle_groups.id "
            . "WHERE exercises.id = :id "
            . "LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Opravená metoda create přijímá pole $data
    public function create(array $data): bool
    {
        $sql = "INSERT INTO exercises (title, muscle_group_id, equipment, difficulty, description, image_path, video_link)"
            . " VALUES (:title, :muscle_group_id, :equipment, :difficulty, :description, :image_path, :video_link)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title' => $data['title'],
            ':muscle_group_id' => $data['muscle_group_id'],
            ':equipment' => $data['equipment'],
            ':difficulty' => $data['difficulty'],
            ':description' => $data['description'],
            ':image_path' => $data['image_path'] ?? null,
            ':video_link' => $data['video_link'] ?? null,
        ]);
    }

    // Opravená metoda update přijímá pole $data
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE exercises SET 
                title = :title, 
                muscle_group_id = :muscle_group_id, 
                equipment = :equipment, 
                difficulty = :difficulty, 
                description = :description, 
                video_link = :video_link";

        $params = [
            ':id' => $id,
            ':title' => $data['title'],
            ':muscle_group_id' => $data['muscle_group_id'],
            ':equipment' => $data['equipment'],
            ':difficulty' => $data['difficulty'],
            ':description' => $data['description'],
            ':video_link' => $data['video_link'] ?? null,
        ];

        // Pokud se nahrál nový obrázek, přidáme ho do dotazu
        if (isset($data['image_path']) && $data['image_path'] !== null) {
            $sql .= ", image_path = :image_path";
            $params[':image_path'] = $data['image_path'];
        }

        $sql .= " WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM exercises WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}