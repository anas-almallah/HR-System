<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . "/../config/db.php";
include_once __DIR__ . "/../models/Payroll.php";

class PayrollController {
    private $payrollModel;
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
if (!isset($_SESSION['user_name']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: /HrSystem/controllers/AuthController.php?action=loginView");
    exit();
}

        $this->payrollModel = new Payroll();
    }

    public function index() {
        $payrolls = $this->payrollModel->getAll();
        $pageTitle = "Payroll List";
        ob_start();
        include __DIR__ . "/../views/payroll/list.php";
        $content = ob_get_clean();
        include __DIR__ . "/../public/MasterPage.php";
    }

    public function create() {
        $departments = [];
        $sql = "SELECT * FROM departments";
        $result = $this->conn->query($sql);
        if ($result) {
            $departments = $result->fetch_all(MYSQLI_ASSOC);
        }

        $pageTitle = "Add Payroll";
        ob_start();
        include __DIR__ . "/../views/payroll/create.php";
        $content = ob_get_clean();
        include __DIR__ . "/../public/MasterPage.php";
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $emp_id = $_POST['emp_id'];
            $month = $_POST['month'];
            $basic_salary = $_POST['basic_salary'];
            $allowances = $_POST['allowances'] ?? 0;
            $deductions = $_POST['deductions'] ?? 0;

            $this->payrollModel->create($emp_id, $month, $basic_salary, $allowances, $deductions);

            $_SESSION['message'] = "Payroll added successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: PayrollController.php?action=index");
            exit();
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        if ($id) {
            $this->payrollModel->delete($id);
            $_SESSION['message'] = "Payroll deleted successfully!";
            $_SESSION['msg_type'] = "danger";
        }
        header("Location: PayrollController.php?action=index");
        exit();
    }

    public function getEmployeesByDept() {
        $dept_id = intval($_GET['dept_id'] ?? 0);
        if ($dept_id <= 0) {
            echo json_encode([]);
            exit();
        }

        $employees = $this->payrollModel->getEmployeesByDept($dept_id);
        echo json_encode($employees);
        exit();
    }
}

$controller = new PayrollController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index': $controller->index(); break;
    case 'create': $controller->create(); break;
    case 'store': $controller->store(); break;
    case 'delete': $controller->delete(); break;
    case 'getEmployeesByDept': $controller->getEmployeesByDept(); break;
    default: $controller->index(); break;
}
