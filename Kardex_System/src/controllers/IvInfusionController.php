<?php
require_once __DIR__ . '/../models/IVFInfusion.php';

class IVFInfusionController {
    private $ivfModel;

    // Constructor to link the model
    public function __construct() {
        $this->ivfModel = new IVFInfusion();
    }

    // Adds a new IVF record for a patient
    public function add($data) {
        if (
            empty($data['patient_id']) ||
            empty($data['date']) ||
            empty($data['bottle_no']) ||
            empty($data['ivf']) ||
            empty($data['rate'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'All fields are required.']);
            return;
        }

        $success = $this->ivfModel->addIVF(
            $data['patient_id'],
            $data['date'],
            $data['bottle_no'],
            $data['ivf'],
            $data['rate']
        );

        echo json_encode(['success' => $success]);
    }

    // Fetches all IVF/Infusion records by patient
    public function getByPatient($patient_id) {
        $ivfs = $this->ivfModel->getIVFsByPatient($patient_id);
        echo json_encode($ivfs);
    }
}
