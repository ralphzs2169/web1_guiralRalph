<?php
require_once __DIR__ . '/../config/database.php';

class Attachment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Adds a new file attachment for a specific patient
    public function addAttachment($patient_id, $file_name, $file_path) {
        $stmt = $this->pdo->prepare("INSERT INTO attachments (patient_id, file_name, file_path, uploaded_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$patient_id, $file_name, $file_path]);
    }

    // Retrieves all attachments for a given patient
    public function getAttachmentsByPatient($patient_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM attachments WHERE patient_id = ? ORDER BY uploaded_at DESC");
        $stmt->execute([$patient_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAttachments() {
        $stmt = $this->pdo->prepare("SELECT * FROM attachments ORDER BY uploaded_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

