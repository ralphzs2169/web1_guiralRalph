<?php
// Handles user-related database operations, such as registering users, logging them, etc.
require_once __DIR__ . '/../config/database.php';

class User {

    // Get all users
    public function getAllUsers() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    // Fetches a single user by their email, used for login
    public function getUserByEmail($email) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(); 
    }

    // registers a new user by inserting their info into the users table
    public function register($lastname, $firstname, $midinit, $email, $password, $department_id, $passcode, $contactNo) {
        global $pdo;
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $hashedPasscode = password_hash($passcode, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (lastname, firstname, midinit, email, password, passcode, department_id. contactNo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$lastname, $firstname, $midinit, $email, $hashedPassword, $hashedPasscode, $department_id, $contactNo]);
    }

    // compares the typed password during login with the one stored in the database
    public function verifyPassword($inputPassword, $hashedPassword) {
        return password_verify($inputPassword, $hashedPassword);
    }    

    public function verifyPasscode($inputPasscode, $hashedPasscode) {
        return password_verify($inputPasscode, $hashedPasscode);
    }

    // retreives a user from the database based on their unique user_id
    public function getUserById($user_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }

    // Update passcode for a user after verifying the current password
    public function updatePasscode($user_id, $currentPassword, $newPasscode) {
        global $pdo;
        // Fetch the current user's data
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if (!$user) {
            return ['error' => 'User not found.'];
        }
        // Verify that the current password is correct
        if (!password_verify($currentPassword, $user['password'])) {
            return ['error' => 'Current password is incorrect.'];
        }
        // Validate that the new passcode is exactly 4 digits long
        if (!preg_match("/^\d{4}$/", $newPasscode)) {
            return ['error' => 'Passcode must be exactly 4 digits.'];
        }
        // Hash the new passcode
        $hashedPasscode = password_hash($newPasscode, PASSWORD_BCRYPT);
        // Update the passcode in the database
        $stmt = $pdo->prepare("UPDATE users SET passcode = ? WHERE user_id = ?");
        if ($stmt->execute([$hashedPasscode, $user_id])) {
            return ['success' => true];
        } else {
            return ['error' => 'Failed to update passcode.'];
        }
    }
}
