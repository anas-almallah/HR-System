<?php
include_once __DIR__ . "/../config/db.php";

class Payroll {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

public function getAll() {
    $sql = "SELECT p.*, e.name as emp_name, 
                   (p.basic_salary + p.allowances - p.deductions) AS net_salary
            FROM payroll p
            JOIN employees e ON p.emp_id = e.id
            ORDER BY p.id DESC";
    $result = $this->conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}


public function getById($id) {
    $sql = "SELECT p.*, e.name as emp_name,
                   (p.basic_salary + p.allowances - p.deductions) AS net_salary
            FROM payroll p
            JOIN employees e ON p.emp_id = e.id
            WHERE p.id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}


public function create($emp_id, $month, $basic_salary, $allowances, $deductions) {
    $sql = "INSERT INTO payroll (emp_id, month, basic_salary, allowances, deductions) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("isddd", $emp_id, $month, $basic_salary, $allowances, $deductions);
    return $stmt->execute();
}


    public function delete($id) {
        $sql = "DELETE FROM payroll WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

public function getEmployeesByDept($dept_id) {
    $sql = "SELECT id, name, salary FROM employees WHERE dept_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $dept_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

}
