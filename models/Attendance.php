<?php
class Attendance {
    private $conn;
    private $table = "attendance";

    public function __construct($db){
        $this->conn = $db;
    }

    public function mark($emp_id, $date, $status) {
        $stmt = $this->conn->prepare("SELECT id FROM {$this->table} WHERE emp_id=? AND date=?");
        $stmt->bind_param("is", $emp_id, $date);
        $stmt->execute();
        if($stmt->get_result()->num_rows > 0) {
            error_log("Attendance already marked for emp_id: $emp_id, date: $date");
            return false;
        }

        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (emp_id, date, status) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $emp_id, $date, $status);
        $result = $stmt->execute();
        if (!$result) {
            error_log("Error inserting attendance for emp_id: $emp_id, error: " . $stmt->error);
        }
        return $result;
    }

    public function getAllDepartments() {
        $sql = "SELECT * FROM departments ORDER BY name";
        $result = $this->conn->query($sql);
        if (!$result) {
            error_log("Error getting departments: " . $this->conn->error);
            return [];
        }
        $departments = $result->fetch_all(MYSQLI_ASSOC);
        error_log("Departments retrieved: " . json_encode($departments));
        return $departments;
    }

    public function getEmployeesByDept($dept_id) {
        $month = date('m');
        $year = date('Y');
        $sql = "SELECT e.id, e.name,
                       COALESCE(SUM(CASE WHEN a.status='Present' THEN 1 ELSE 0 END), 0) AS present_days,
                       COALESCE(SUM(CASE WHEN a.status='Absent' THEN 1 ELSE 0 END), 0) AS absent_days
                FROM employees e
                LEFT JOIN {$this->table} a ON e.id = a.emp_id
                    AND MONTH(a.date)=? AND YEAR(a.date)=?
                WHERE e.dept_id=?
                GROUP BY e.id
                ORDER BY e.name";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Error preparing query for getEmployeesByDept: " . $this->conn->error);
            return [];
        }
        $stmt->bind_param("iii", $month, $year, $dept_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            error_log("Error executing getEmployeesByDept: " . $stmt->error);
            return [];
        }
        $employees = $result->fetch_all(MYSQLI_ASSOC);
        error_log("Employees retrieved for dept_id $dept_id: " . json_encode($employees));
        return $employees;
    }

    public function getMonthlyReportByDept($month, $year, $dept_id = 0) {
        $sql = "SELECT e.name,
                       COALESCE(SUM(CASE WHEN a.status='Present' THEN 1 ELSE 0 END), 0) AS present_days,
                       COALESCE(SUM(CASE WHEN a.status='Absent' THEN 1 ELSE 0 END), 0) AS absent_days
                FROM {$this->table} a
                JOIN employees e ON a.emp_id = e.id
                WHERE MONTH(a.date)=? AND YEAR(a.date)=?";
        $types = "ii";
        $params = [$month, $year];

        if($dept_id > 0){
            $sql .= " AND e.dept_id=?";
            $types .= "i";
            $params[] = $dept_id;
        }

        $sql .= " GROUP BY e.id ORDER BY e.name";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Error preparing query for getMonthlyReportByDept: " . $this->conn->error);
            return [];
        }
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            error_log("Error executing getMonthlyReportByDept: " . $stmt->error);
            return [];
        }
        $report = $result->fetch_all(MYSQLI_ASSOC);
        error_log("Monthly report retrieved: " . json_encode($report));
        return $report;
    }
}
?>