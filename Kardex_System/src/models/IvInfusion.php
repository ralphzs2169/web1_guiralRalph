<?php
require_once __DIR__ . '/../config/database.php';

class IVFInfusion {

    // Adds a new IV fluid/infusion record for a patient
    public function addIVF($patient_id, $date, $bottle_no, $ivf, $rate) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO ivf_infusion (patient_id, date, bottle_no, ivf, rate, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([$patient_id, $date, $bottle_no, $ivf, $rate]);
    }

    // Retrieves all IV fluid/infusion records for a specific patient
    public function getIVFsByPatient($patient_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM ivf_infusion WHERE patient_id = ? ORDER BY created_at DESC");
        $stmt->execute([$patient_id]);
        return $stmt->fetchAll();
    }
}
