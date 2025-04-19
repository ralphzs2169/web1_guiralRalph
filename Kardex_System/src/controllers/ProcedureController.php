<?php
require_once __DIR__ . '/../models/Procedure.php';

class ProcedureController {
    private $procedureModel;

    public function __construct($pdo) {
        $this->procedureModel = new Procedure($pdo);
    }

    // Add a procedure
    public function add($data) {
        if (
            empty($data['patient_id']) ||
            empty($data['procedure_name']) ||
            empty($data['procedure_date']) ||
            empty($data['contraption_start_date']) ||
            empty($data['laboratory_diagnostic']) ||
            empty($data['status'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'All fields are required.']);
            return;
        }

        $success = $this->procedureModel->addProcedure(
            $data['patient_id'],
            $data['procedure_name'],
            $data['procedure_date'],
            $data['contraption_start_date'],
            $data['laboratory_diagnostic'],
            $data['status']
        );

        echo json_encode(['success' => $success]);
    }

    // Get procedures for a patient
    public function getByPatient($patient_id) {
        $procedures = $this->procedureModel->getProceduresByPatient($patient_id);
        echo json_encode($procedures);
    }

    // Delete a procedure
    public function deleteProcedure() {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['procedure_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Procedure ID is required']);
            return;
        }
    
        $procedureId = $data['procedure_id'];
        $result = $this->procedureModel->deleteProcedure($procedureId);
    
        echo json_encode(['success' => $result]);
    }

    // Update a procedure
    public function updateProcedure() {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['procedure_id']) || !isset($data['procedure_name']) || !isset($data['procedure_date']) || !isset($data['contraption_start_date']) || !isset($data['laboratory_diagnostic']) || !isset($data['status'])) {
            http_response_code(400);
            echo json_encode(['error' => 'All fields are required']);
            return;
        }
    
        $result = $this->procedureModel->updateProcedure($data);
    
        echo json_encode(['success' => $result]);
    }
    
}
