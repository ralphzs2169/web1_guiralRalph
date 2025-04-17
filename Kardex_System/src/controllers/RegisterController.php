<?php
require_once __DIR__ . '/../models/User.php';

class RegisterController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function register($data) {
        if (
            empty($data['lastname']) ||
            empty($data['firstname']) ||
            empty($data['midinit']) ||
            empty($data['email']) ||
            empty($data['password']) ||
            empty($data['passcode']) ||
            empty($data['department_id'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'All fields are required.']);
            return;
        }

        $existing = $this->userModel->getUserByEmail($data['email']);
        if ($existing) {
            http_response_code(409);
            echo json_encode(['error' => 'Email already exists.']);
            return;
        }

        $success = $this->userModel->register(
            $data['lastname'],
            $data['firstname'],
            $data['midinit'],
            $data['email'],
            $data['password'],
            $data['department_id'],
            $data['passcode'],
            $data['contactNo'] ?? null
        );

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'User registered successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Something went wrong.']);
        }
    }

    public function updatePasscode($data) {
        if (empty($data['user_id']) || empty($data['current_password']) || empty($data['new_passcode'])) {
            http_response_code(400);
            echo json_encode(['error' => 'User ID, current password, and new passcode are required.']);
            return;
        }

        $result = $this->userModel->updatePasscode($data['user_id'], $data['current_password'], $data['new_passcode']);

        if (isset($result['success']) && $result['success']) {
            echo json_encode(['success' => true, 'message' => 'Passcode updated successfully.']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => $result['error']]);
        }
    }
}
