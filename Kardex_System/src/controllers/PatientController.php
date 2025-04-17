<?php
//Handles logic like validating form data and calling the model to store it.
require_once __DIR__ . '/../models/Patients.php';

class PatientController {
    private $patientModel;

    public function __construct() {
        $this->patientModel = new Patient();
    }

    public function create($data) {
        if (
            empty($data['lastname']) ||
            empty($data['firstname']) ||
            empty($data['midinit']) ||
            empty($data['bed_id']) ||
            empty($data['age']) ||
            empty($data['gender']) ||
            empty($data['diagnosis']) 
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'All required fields must be filled out.']);
            return;
        }

        $success = $this->patientModel->createPatient(
            $data['lastname'],
            $data['firstname'],
            $data['midinit'],
            (int)$data['age'],
            $data['gender'],
            $data['diagnosis'],
            $data['bed_id'],
            $data['contactNo'] ?? null
        );

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Patient added successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add patient.']);
        }
    }

    public function update($patient_id, $data) {
        if (
            empty($data['lastname']) ||
            empty($data['firstname']) ||
            empty($data['midinit']) ||
            empty($data['bed_id']) ||
            empty($data['age']) ||
            empty($data['gender']) ||
            empty($data['diagnosis'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'Required fields are missing.']);
            return;
        }
    
        $success = $this->patientModel->updatePatient(
            $patient_id,
            $data['lastname'],
            $data['firstname'],
            $data['midinit'],
            (int)$data['age'],
            $data['bed_id'],
            $data['gender'],
            $data['diagnosis'],
            $data['contactNo'] ?? null
        );
    
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Patient updated successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update patient.']);
        }
    }

    public function getByBedId($bed_id) {
        $patient = $this->patientModel->getPatientByBedId($bed_id);
    
        if ($patient) {
            echo json_encode(['success' => true, 'patient' => $patient]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No patient found for this bed.']);
        }
    }
}
