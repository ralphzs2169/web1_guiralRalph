<?php
require_once __DIR__ . '/../models/Patient.php';

class PatientController
{
    private $patientModel;

    public function __construct($pdo)
    {
        $this->patientModel = new Patient($pdo);
    }

    private function respondJson($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // Validate patient input
    public function validatePatientData($data)
    {
        $errors = [];

        if (empty($data['lastname'])) $errors['emptyLastname'] = 'Last name is required.';
        if (empty($data['firstname'])) $errors['emptyFirstname'] = 'First name is required.';
        if (empty($data['bedId'])) $errors['emptyBed'] = 'Bed must be assigned.';
        if (empty($data['gender'])) $errors['emptyGender'] = 'Gender is required.';
        if (empty($data['diagnosis'])) $errors['emptyDiagnosis'] = 'Diagnosis is required.';
        if (empty($data['civilStatus'])) $errors['emptyStatus'] = 'Status is required.';
        if (empty($data['nationality'])) $errors['emptyNationality'] = 'Nationality is required.';
        if (empty($data['religion'])) $errors['emptyReligion'] = 'Religion is required.';
        if (empty($data['physician'])) $errors['emptyPhysician'] = 'Physician is required.';
        if (empty($data['dob'])) $errors['emptyDOB'] = 'Date of birth is required.';

        return $errors;
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

        $success = $this->patientModel->createPatient(
            $data['lastname'],
            $data['firstname'],
            $data['midInit'],
            $data['gender'],
            $data['diagnosis'],
            $data['bedId'],
            $data['civilStatus'],
            $data['nationality'],
            $data['religion'],
            $data['physician'],
            $data['dob']
        );

        if ($success) {
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
