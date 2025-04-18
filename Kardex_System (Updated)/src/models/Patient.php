<?php
// This will handle all database interactions related to patients.

class Patient
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Fetch all patients
    public function getAllPatients()
    {
        $stmt = $this->pdo->query("SELECT * FROM patients ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    // Fetch patient by ID
    public function getPatientById($patient_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM patients WHERE patient_id = ?");
        $stmt->execute([$patient_id]);
        return $stmt->fetch();
    }

    // Fetch patient by bed ID
    public function getPatientByBedId($bed_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM patients WHERE bed_id = ?");
        $stmt->execute([$bed_id]);
        return $stmt->fetch();
    }

    // Create a new patient
    public function createPatient($lastname, $firstname, $midinit, $gender, $diagnosis, $bed_id, $status, $nationality, $religion, $physician, $date_of_birth)
    {
        $stmt = $this->pdo->prepare("INSERT INTO patients (lastname, firstname, midinit, gender, diagnosis, bed_id, status, nationality, religion, physician, date_of_birth) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        return $stmt->execute([
            $lastname,
            $firstname,
            $midinit,
            $gender,
            $diagnosis,
            $bed_id,
            $status,
            $nationality,
            $religion,
            $physician,
            $date_of_birth
        ]);
    }

    // Delete a patient
    public function deletePatient($patient_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM patients WHERE patient_id = ?");
        return $stmt->execute([$patient_id]);
    }

    // Update a patient
    public function updatePatient($patient_id, $lastname, $firstname, $midinit, $bed_id, $gender, $diagnosis, $status, $nationality, $religion, $physician, $date_of_birth)
    {
        $stmt = $this->pdo->prepare("UPDATE patients SET lastname = ?, firstname = ?, midinit = ?, bed_id = ?, gender = ?, diagnosis = ?, status = ?, nationality = ?, religion = ?, physician = ?, date_of_birth = ? WHERE patient_id = ?");

        return $stmt->execute([
            $lastname,
            $firstname,
            $midinit,
            $bed_id,
            $gender,
            $diagnosis,
            $status,
            $nationality,
            $religion,
            $physician,
            $date_of_birth,
            $patient_id
        ]);
    }
}
