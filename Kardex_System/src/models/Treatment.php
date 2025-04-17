<?php
require_once __DIR__ . '/../config/database.php';

class Treatment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Inserts a new treatment entry for a specific patient
    public function addTreatment($patient_id, $treatment_text) {
        $stmt = $this->pdo->prepare("INSERT INTO treatments (patient_id, treatment_text, created_at) VALUES (?, ?, NOW())");
        return $stmt->execute([$patient_id, $treatment_text]);
    }

    // Retrieves all treatments linked to a specific patient, sorted by most recent
    public function getTreatmentsByPatient($patient_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM treatments WHERE patient_id = ? ORDER BY created_at DESC");
        $stmt->execute([$patient_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

