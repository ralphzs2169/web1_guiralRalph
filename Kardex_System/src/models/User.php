<?php
// Handles user-related database operations, such as registering users, logging them, etc.

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(); 
    }

    public function register($lastname, $firstname, $midinit, $email, $password, $department_id, $passcode, $contactNo) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $hashedPasscode = password_hash($passcode, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO users (lastname, firstname, midinit, email, password, passcode, department_id, contactNo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$lastname, $firstname, $midinit, $email, $hashedPassword, $hashedPasscode, $department_id, $contactNo]);
    }

    public function verifyPassword($inputPassword, $hashedPassword) {
        return password_verify($inputPassword, $hashedPassword);
    }    

    public function verifyPasscode($inputPasscode, $hashedPasscode) {
        return password_verify($inputPasscode, $hashedPasscode);
    }

    public function getUserById($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }

    public function updatePasscode($user_id, $currentPassword, $newPasscode) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if (!$user) {
            return ['error' => 'User not found.'];
        }

        if (!password_verify($currentPassword, $user['password'])) {
            return ['error' => 'Current password is incorrect.'];
        }

        if (!preg_match("/^\d{4}$/", $newPasscode)) {
            return ['error' => 'Passcode must be exactly 4 digits.'];
        }

        $hashedPasscode = password_hash($newPasscode, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("UPDATE users SET passcode = ? WHERE user_id = ?");
        if ($stmt->execute([$hashedPasscode, $user_id])) {
            return ['success' => true];
        } else {
            return ['error' => 'Failed to update passcode.'];
        }
    }
}
