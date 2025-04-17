<?php
require_once __DIR__ . '/../config/database.php';

class Treatment {

    // Inserts a new treatment entry for a specific patient
    public function addTreatment($patient_id, $treatment_text) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO treatment (patient_id, treatment_text, created_at) VALUES (?, ?, NOW())");
        return $stmt->execute([$patient_id, $treatment_text]);
    }

    // Retrieves all treatments linked to a specific patient, sorted by most recent
    public function getTreatmentsByPatient($patient_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM treatment WHERE patient_id = ? ORDER BY created_at DESC");
        $stmt->execute([$patient_id]);
        return $stmt->fetchAll();
    }
}
