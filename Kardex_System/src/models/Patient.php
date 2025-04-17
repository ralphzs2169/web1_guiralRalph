<?php
//This will handle all database interactions related to patients.
require_once __DIR__ . '/../config/database.php';

class Patient {

    // fetch all the patients
    public function getAllPatients() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM patients ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    // fetch patient by id
    public function getPatientById($patient_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ?");
        $stmt->execute([$patient_id]);
        return $stmt->fetch();
    }

    // fetch patient by bed id (but this assumes that a bed can only have one patient at a time)
    public function getPatientByBedId($bed_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM patients WHERE bed_id = ?");
        $stmt->execute([$bed_id]);
        return $stmt->fetch(); // returns false if no patient is assigned to that bed
    }    

    // create a new patient
    public function createPatient($lastname, $firstname, $midinit, $age, $gender, $diagnosis, $bed_id, $contactNo = null) {
        global $pdo;
        $stmt = $pdo->prepare("
            INSERT INTO patients (lastname, firstname, midinit, age, gender, diagnosis, contactNo, bed_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$lastname, $firstname, $midinit, $age, $gender, $diagnosis, $bed_id, $contactNo]);
    }

    // delete a patient
    public function deletePatient($patient_id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM patients WHERE patient_id = ?");
        return $stmt->execute([$patient_id]);
    }

    // update a patient's information details
    public function updatePatient($patient_id, $lastname, $firstname, $midinit, $age, $gender, $diagnosis, $bed_id, $contactNo = null) {
        global $pdo;
    
        $stmt = $pdo->prepare("
            UPDATE patients 
            SET lastname = ?, firstname = ?, midinit = ?, age = ?, gender = ?, diagnosis = ?,  bed_id = ?, contactNo = ?
            WHERE patient_id = ?
        ");
    
        return $stmt->execute([
            $lastname, $firstname, $midinit, $age, $gender, $diagnosis,  $bed_id, $contactNo, $patient_id
        ]);
    }    
}
