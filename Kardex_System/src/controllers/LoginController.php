<?php
require_once __DIR__ . '/../models/User.php';

class LoginController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login($data) {
        // Validate email and password
        if (empty($data['email']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Email and password are required.']);
            return;
        }

        // Check if the user exists by email
        $user = $this->userModel->getUserByEmail($data['email']);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found.']);
            return;
        }

        // Verify password
        if (!$this->userModel->verifyPassword($data['password'], $user['password'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid password.']);
            return;
        }

        // Password is correct, generate a session or token (simple example)
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];

        echo json_encode(['success' => true, 'message' => 'Login successful.']);
    }
}
