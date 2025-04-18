<?php
require_once __DIR__ . '/../models/Bed.php';
require_once __DIR__ . '/../models/Patient.php';

class BedController
{
    private $bedModel;
    private $patientModel;

    public function __construct()
    {
        $this->bedModel = new Bed();
        $this->patientModel = new Patient();
    }

    // Fetch all beds
    public function getAllBeds()
    {
        $beds = $this->bedModel->getAllBeds();
        echo json_encode($beds);
    }

    // Get bed details by bed number
    public function getBedByNumber($bed_number)
    {
        $bed = $this->bedModel->getBedByNumber($bed_number);
        if ($bed) {
            echo json_encode($bed);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Bed not found.']);
        }
    }

    // Assign a patient to a bed (check if the bed is available first)
    public function assignBedToPatient($patient_id, $bed_number)
    {
        // Check if bed exists
        $bed = $this->bedModel->getBedByNumber($bed_number);
        if ($bed) {
            // Check if the patient already has a bed
            $patient = $this->patientModel->getPatientById($patient_id);
            if ($patient && empty($patient['bed_id'])) {
                $this->bedModel->assignBedToPatient($patient_id, $bed_number);
                echo json_encode(['success' => true, 'message' => 'Bed assigned to patient.']);
            } else {
                echo json_encode(['error' => 'Patient already has a bed or invalid patient ID.']);
            }
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Bed not found.']);
        }
    }

    // Remove bed assignment (optional, depend sa atong flow)
    public function removeBedAssignment($patient_id)
    {
        $patient = $this->patientModel->getPatientById($patient_id);
        if ($patient) {
            $this->bedModel->assignBedToPatient($patient_id, null);
            echo json_encode(['success' => true, 'message' => 'Bed assignment removed.']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Patient not found.']);
        }
    }
}
