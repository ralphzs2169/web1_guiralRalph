<?php
require_once __DIR__ . '/../models/Endorsement.php';

class EndorsementController {
    private $endorsementModel;

    public function __construct() {
        $this->endorsementModel = new Endorsement();
    }

    // called when a user submits a new note
    public function create($data) {
        if (empty($data['user_id']) || empty($data['patient_id']) || empty($data['note'])) {
            http_response_code(400);
            echo json_encode(['error' => 'All fields are required.']);
            return;
        }

        $success = $this->endorsementModel->createNote($data['user_id'], $data['patient_id'], $data['note']);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Note saved successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to save note.']);
        }
    }

    // retreives all notes written by a specific user for a specific patient
    public function getNotes($user_id, $patient_id) {
        $notes = $this->endorsementModel->getNotesByUserAndPatient($user_id, $patient_id);
        echo json_encode($notes);
    }
}
