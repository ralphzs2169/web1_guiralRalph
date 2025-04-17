<?php
require_once __DIR__ . '/../models/Department.php';

class DepartmentController {
    private $departmentModel;

    public function __construct() {
        $this->departmentModel = new Department();
    }

    // Get all departments
    public function getDepartments() {
        $departments = $this->departmentModel->getAllDepartments();
        echo json_encode($departments);
    }

    // Get a department by ID
    public function getDepartment($department_id) {
        $department = $this->departmentModel->getDepartmentById($department_id);
        if ($department) {
            echo json_encode($department);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Department not found.']);
        }
    }
}
