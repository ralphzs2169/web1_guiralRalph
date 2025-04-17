<?php
require_once __DIR__ . '/../models/Treatment.php';

class TreatmentController {
    private $treatmentModel;

    public function __construct() {
        $this->treatmentModel = new Treatment();
    }

    // Adds a new treatment record (expects patient_id and treatment_text from frontend)
    public function add($data) {
        // Validates required fields
        if (empty($data['patient_id']) || empty($data['treatment_text'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing patient ID or treatment details.']);
            return;
        }

        // Calls the model to add treatment
        $success = $this->treatmentModel->addTreatment($data['patient_id'], $data['treatment_text']);
        echo json_encode(['success' => $success]);
    }

    // Fetches all treatments by patient ID
    public function getByPatient($patient_id) {
        $treatments = $this->treatmentModel->getTreatmentsByPatient($patient_id);
        echo json_encode($treatments);
    }
}
