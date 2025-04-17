<?php
require_once __DIR__ . '/../models/Referral.php';

class ReferralController {
    private $referralModel;

    public function __construct() {
        $this->referralModel = new Referral();
    }

    // Handles adding a new referral (expects patient_id, department_id, reason)
    public function add($data) {
        if (
            empty($data['patient_id']) ||
            empty($data['department_id']) ||
            empty($data['reason'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'All fields are required (patient, department, reason).']);
            return;
        }

        $success = $this->referralModel->addReferral(
            $data['patient_id'],
            $data['department_id'],
            $data['reason']
        );

        echo json_encode(['success' => $success]);
    }

    // Gets all referrals for a patient
    public function getByPatient($patient_id) {
        $referrals = $this->referralModel->getReferralsByPatient($patient_id);
        echo json_encode($referrals);
    }
}
