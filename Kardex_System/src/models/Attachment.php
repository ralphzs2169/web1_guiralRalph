<?php
require_once __DIR__ . '/../config/database.php';

class Attachment {

    // Adds a new file attachment for a specific patient
    public function addAttachment($patient_id, $file_name, $file_path) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO attachment (patient_id, file_name, file_path, uploaded_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$patient_id, $file_name, $file_path]);
    }

    // Retrieves all attachments for a given patient
    public function getAttachmentsByPatient($patient_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM attachment WHERE patient_id = ? ORDER BY uploaded_at DESC");
        $stmt->execute([$patient_id]);
        return $stmt->fetchAll();
    }
}
