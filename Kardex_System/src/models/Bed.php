<?php
require_once __DIR__ . '/../config/database.php';

class Bed {

    // Function to fetch all beds (useful for the bed list)
    public function getAllBeds() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM beds");
        return $stmt->fetchAll();
    }

    // Fetch a bed by its bed number (used for showing patient bed assignments)
    public function getBedByNumber($bed_number) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM beds WHERE bed_number = ?");
        $stmt->execute([$bed_number]);
        return $stmt->fetch();
    }

    // Assign a patient to a bed (not necessary if this is handled in the patient record)
    public function assignBedToPatient($patient_id, $bed_number) {
        global $pdo;
        // Assign bed to patient based on the bed number and patient ID
        $stmt = $pdo->prepare("UPDATE patients SET bed_id = (SELECT bed_id FROM beds WHERE bed_number = ?) WHERE patient_id = ?");
        return $stmt->execute([$bed_number, $patient_id]);
    }

    // Remove a bed (optional)
    public function deleteBed($bed_id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM beds WHERE bed_id = ?");
        return $stmt->execute([$bed_id]);
    }
}
?>
