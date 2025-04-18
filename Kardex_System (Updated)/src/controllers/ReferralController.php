<?php
require_once __DIR__ . '/../models/Referral.php';

class ReferralController
{
    private $referralModel;

    public function __construct($pdo)
    {
        $this->referralModel = new Referral($pdo);
    }

    // Handles adding a new referral (expects patient_id, department_id, reason)
    public function add($data)
    {
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

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Referral added successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add referral.']);
        }
    }

    // Gets all referrals for a patient
    public function getByPatient($patient_id)
    {
        if (empty($patient_id)) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing patient ID.']);
            return;
        }

        $referrals = $this->referralModel->getReferralsByPatient($patient_id);
        echo json_encode($referrals);
    }
}
