<?php
include_once __DIR__ . "/../config/db.php";
include_once __DIR__ . "/Department.php"; 

class Employee {
    private $conn;
    private $departmentModel;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
        $this->departmentModel = new Department();
    }

    public function getAll() {
        $sql = "SELECT e.*, d.name AS dept_name 
                FROM employees e
                LEFT JOIN departments d ON e.dept_id = d.id";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

public function getByDept($dept_id = 0) {
    if($dept_id > 0){
        $stmt = $this->conn->prepare("SELECT id, name FROM employees WHERE dept_id=?");
        $stmt->bind_param("i", $dept_id);
    } else {
        $stmt = $this->conn->prepare("SELECT id, name FROM employees");
    }
    $stmt->execute();
    $result = $stmt->get_result();
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}



    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM employees WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($name, $email, $phone, $dept_id, $salary) {
        $stmt = $this->conn->prepare("INSERT INTO employees (name, email, phone, dept_id, salary) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdd", $name, $email, $phone, $dept_id, $salary);
        return $stmt->execute();
    }

    public function update($id, $name, $email, $phone, $dept_id, $salary) {
        $stmt = $this->conn->prepare("UPDATE employees SET name=?, email=?, phone=?, dept_id=?, salary=? WHERE id=?");
        $stmt->bind_param("sssddi", $name, $email, $phone, $dept_id, $salary, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM employees WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getDepartments() {
        return $this->departmentModel->getAll();
    }
}
