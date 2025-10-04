<?php
session_start();

try {
    $db = new PDO("mysql:host=localhost;dbname=hr_system;charset=utf8mb4", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

class LeaveController {
    private $db;
    private $baseURL = "/HrSystem/"; 

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    private function getEmployeeId() {
        $username = $_SESSION['user_name'];
        $stmt = $this->db->prepare("SELECT id FROM employees WHERE name = ?");
        $stmt->execute([$username]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);
        return $employee['id'] ?? null;
    }

    public function create() {
        if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'employee') {
            header("Location: " . $this->baseURL . "controllers/AuthController.php?action=loginView");
            exit();
        }
        include __DIR__ . '/../views/leaves/leave_form.php';
    }

    public function store() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'employee') {
                header("Location: " . $this->baseURL . "controllers/AuthController.php?action=loginView");
                exit();
            }

            $emp_id = $this->getEmployeeId();
            if (!$emp_id) {
                $_SESSION['message'] = "Employee not found!";
                $_SESSION['msg_type'] = "danger";
                header("Location: " . $this->baseURL . "controllers/LeaveController.php?action=create");
                exit();
            }

            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';
            $reason = trim($_POST['reason'] ?? '');

            $stmt = $this->db->prepare("INSERT INTO leaves (emp_id, start_date, end_date, reason) VALUES (?, ?, ?, ?)");
            $stmt->execute([$emp_id, $start_date, $end_date, $reason]);

            $_SESSION['message'] = "Leave request submitted successfully!";
            $_SESSION['msg_type'] = "success";
            header("Location: " . $this->baseURL . "controllers/LeaveController.php?action=index");
            exit();
        }
    }

    public function index() {
        if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'employee') {
            header("Location: " . $this->baseURL . "controllers/AuthController.php?action=loginView");
            exit();
        }

        $emp_id = $this->getEmployeeId();
        if (!$emp_id) {
            $_SESSION['message'] = "Employee not found!";
            $_SESSION['msg_type'] = "danger";
            header("Location: " . $this->baseURL . "controllers/LeaveController.php?action=create");
            exit();
        }

        $stmt = $this->db->prepare("SELECT * FROM leaves WHERE emp_id = ? ORDER BY id DESC");
        $stmt->execute([$emp_id]);
        $leaves = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../views/leaves/leave_list.php';
    }
}

$controller = new LeaveController($db);

$action = $_GET['action'] ?? 'create';

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'index':
        $controller->index();
        break;
    default:
        echo "Action not found!";
        break;
}
