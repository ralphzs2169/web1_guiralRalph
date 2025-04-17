<?php
require_once __DIR__ . '/../config/database.php';

class Referral {

    // Inserts a new referral record for a patient to a department
    public function addReferral($patient_id, $department_id, $reason) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO referrals (patient_id, department_id, reason, referred_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$patient_id, $department_id, $reason]);
    }

    // Retrieves all referrals for a specific patient, most recent first
    public function getReferralsByPatient($patient_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT r.*, d.name AS department_name 
                               FROM referrals r
                               JOIN departments d ON r.department_id = d.id
                               WHERE r.patient_id = ?
                               ORDER BY referred_at DESC");
        $stmt->execute([$patient_id]);
        return $stmt->fetchAll();
    }
}
