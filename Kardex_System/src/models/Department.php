<?php
require_once __DIR__ . '/../config/database.php';

class Department {

    // Get all departments
    public function getAllDepartments() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM departments");
        return $stmt->fetchAll();
    }

    // Get a department by ID
    public function getDepartmentById($department_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM departments WHERE department_id = ?");
        $stmt->execute([$department_id]);
        return $stmt->fetch();
    }
}
