<?php
session_start();
include_once __DIR__ . "/../config/db.php";
include_once __DIR__ . "/../models/Attendance.php";

class AttendanceController {
    private $attendanceModel;

    public function __construct($db) {
if (!isset($_SESSION['user_name']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: /HrSystem/controllers/AuthController.php?action=loginView");
    exit();
}


        $this->attendanceModel = new Attendance($db);
    }

    public function markView() {
        $departments = $this->attendanceModel->getAllDepartments();
        if (empty($departments)) {
            error_log("No departments found in markView");
        } else {
            error_log("Departments loaded in markView: " . json_encode($departments));
        }

        ob_start();
        include __DIR__ . "/../views/attendance/mark.php";
        $content = ob_get_clean();
        $pageTitle = "Mark Attendance";
        include __DIR__ . "/../public/MasterPage.php";
    }

    public function mark() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $emp_id = intval($_POST['emp_id'] ?? 0);
            $status = $_POST['status'] ?? '';
            $date = date('Y-m-d');

            if ($emp_id > 0 && in_array($status, ['Present', 'Absent'])) {
                $success = $this->attendanceModel->mark($emp_id, $date, $status);
                echo json_encode([
                    'success' => $success,
                    'message' => $success ? 'Attendance marked successfully' : 'Attendance already marked for today'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid employee ID or status'
                ]);
            }
            exit();
        }
    }

    public function getEmployeesByDept() {
        $dept_id = intval($_GET['dept_id'] ?? 0);
        if ($dept_id <= 0) {
            error_log("Invalid dept_id: $dept_id");
            echo json_encode([]);
            exit();
        }

        $employees = $this->attendanceModel->getEmployeesByDept($dept_id);
        if (empty($employees)) {
            error_log("No employees found for dept_id: $dept_id");
        }

        echo json_encode($employees);
        exit();
    }

    public function reportView() {
        $departments = $this->attendanceModel->getAllDepartments();
        $month = intval($_GET['month'] ?? date('m'));
        $year = intval($_GET['year'] ?? date('Y'));
        $dept_id = intval($_GET['dept_id'] ?? 0);

        $report = $this->attendanceModel->getMonthlyReportByDept($month, $year, $dept_id);
        if (empty($report)) {
            error_log("No report data for month: $month, year: $year, dept_id: $dept_id");
        }

        ob_start();
        include __DIR__ . "/../views/attendance/report.php";
        $content = ob_get_clean();
        $pageTitle = "Attendance Report";
        include __DIR__ . "/../public/MasterPage.php";
    }
}

$controller = new AttendanceController($conn);
$action = $_GET['action'] ?? 'markView';

switch ($action) {
    case 'markView':
        $controller->markView();
        break;

    case 'mark':
        $controller->mark();
        break;

    case 'getEmployeesByDept':
        $controller->getEmployeesByDept();
        break;

    case 'reportView':
        $controller->reportView();
        break;

    default:
        http_response_code(404);
        echo "Action not found";
        break;
}
