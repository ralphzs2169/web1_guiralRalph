<?php
require_once __DIR__ . '/../models/Patient.php';
require_once __DIR__ . '/../models/Bed.php';

class PatientController
{
    private $patientModel;
    private $bedModel;

    public function __construct($pdo)
    {
        $this->patientModel = new Patient($pdo);
        $this->bedModel = new Bed($pdo);
    }

    private function respondJson($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit; // ← Make sure to add this!
    }

    // Validate patient input
    public function validatePatientData($data)
    {
        $errors = [];

        if (empty($data['lastname'])) $errors['emptyLastname'] = 'Last name is required.';
        if (empty($data['firstname'])) $errors['emptyFirstname'] = 'First name is required.';
        if (empty($data['bedNumber'])) $errors['emptyBed'] = 'Bed must be assigned.';
        if (empty($data['diagnosis'])) $errors['emptyDiagnosis'] = 'Diagnosis is required.';

        return $errors;
    }

    // Fetch all patients
    public function getAllPatients()
    {
        try {
            $patients = $this->patientModel->getAllPatients();

            return $this->respondJson([
                'success' => true,
                'data' => $patients
            ]);
        } catch (Exception $e) {
            return $this->respondJson([
                'success' => false,
                'message' => 'No patients found.'
            ], 404);
        }
    }


    public function create($data)
    {
        $errors = $this->validatePatientData($data);

        if (!empty($errors)) {
            return $this->respondJson([
                'success' => false,
                'errors' => $errors
            ], 400);
        }

        $bed = $this->bedModel->getBedByNumber($data['bedNumber']);

        if (empty($bed)) {
            return $this->respondJson([
                'success' => false,
                'message' => 'Bed was not'
            ], 400);
        }

        $uuid = $this->generateUuidV4(); //generate random uuid
        $patient_uuid = pack("H*", str_replace('-', '', $uuid)); // convert to 16-byte binary

        $success = $this->patientModel->createPatient(
            $data['lastname'],
            $data['firstname'],
            $data['midInit'],
            $data['gender'],
            $data['diagnosis'],
            $data['civilStatus'],
            $data['nationality'],
            $data['religion'],
            $data['physician'],
            $data['dob'],
            $patient_uuid
        );

        if ($success) {

            $bedAssignmentSucces = $this->bedModel->assignBedToPatient($patient_uuid, $data['bedNumber']);

            if ($bedAssignmentSucces) {
                return $this->respondJson([
                    'success' => true,
                    'message' => 'Patient assigned to a bed'
                ]);
            } else {
                return $this->respondJson([
                    'success' => false,
                    'message' => 'An Error ocurred when assigning a bed to a patient'
                ]);
            }

            return $this->respondJson([
                'success' => true,
                'message' => 'Patient added successfully.'
            ]);
        }

        return $this->respondJson([
            'success' => false,
            'message' => 'Failed to add patient.'
        ], 500);
    }

    function generateUuidV4()
    {
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40); // Version 4
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80); // Variant
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function update($patient_id, $data)
    {
        $errors = $this->validatePatientData($data);

        if (!empty($errors)) {
            return $this->respondJson([
                'success' => false,
                'errors' => $errors
            ], 400);
        }

        $success = $this->patientModel->updatePatient(
            $patient_id,
            $data['lastname'],
            $data['firstname'],
            $data['midinit'],
            $data['bed_id'],
            $data['gender'],
            $data['diagnosis'],
            $data['status'],
            $data['nationality'],
            $data['religion'],
            $data['physician'],
            $data['date_of_birth']
        );

        if ($success) {
            return $this->respondJson([
                'success' => true,
                'message' => 'Patient updated successfully.'
            ]);
        }

        return $this->respondJson([
            'success' => false,
            'message' => 'Failed to update patient.'
        ], 500);
    }

    public function getByBedId($bed_id)
    {
        $patient = $this->patientModel->getPatientByBedId($bed_id);

        if ($patient) {
            return $this->respondJson([
                'success' => true,
                'patient' => $patient
            ]);
        }

        return $this->respondJson([
            'success' => false,
            'error' => 'No patient found for this bed.'
        ], 404);
    }

    // Optional: calculate age from birth date
    public function calculateAge($dob)
    {
        $birthDate = new DateTime($dob);
        $today = new DateTime('today');
        return $birthDate->diff($today)->y;
    }
}
