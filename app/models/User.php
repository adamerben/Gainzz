<?php

class User {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;    
    }

    // 1. Registrace nového uživatele (nyní přijímá i jméno, příjmení a přezdívku)
// 1. Registrace nového uživatele
    public function register($username, $email, $password) {
        // Kontrola, zda uživatel s tímto emailem už neexistuje
        if ($this->findByEmail($email)) {
            return false; 
        }

        // ZABEZPEČENÍ: Vytvoření bezpečného hashe z hesla
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Uložení do databáze
        $sql = "INSERT INTO users (username, email, password) 
                VALUES (:username, :email, :password)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);
    }

    // 2. Nalezení uživatele podle emailu (použijeme při přihlašování)
    public function findByEmail(string $email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        // Vrátí pole s daty uživatele, nebo false pokud neexistuje
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById(int $id) {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function updateProfile(int $id, array $data): bool {
            $sql = "UPDATE users SET weight = :weight, height = :height, bio = :bio WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':id' => $id,
                ':weight' => $data['weight'],
                ':height' => $data['height'],
                ':bio' => $data['bio'],
            ]);
        }
    }
