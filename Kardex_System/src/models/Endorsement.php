<?php
require_once __DIR__ . '/../config/database.php';

class Endorsement {
    // saves a new note written by a user fr a specific patient
    public function createNote($user_id, $patient_id, $note) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO endorsements (user_id, patient_id, note, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$user_id, $patient_id, $note]);
    }

    // retrieves all notes written by a user for a specific patient
    public function getNotesByUserAndPatient($user_id, $patient_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM endorsement WHERE user_id = ? AND patient_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id, $patient_id]);
        return $stmt->fetchAll();
    }
}
