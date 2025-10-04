<?php
session_start();

try {
    $db = new PDO("mysql:host=localhost;dbname=hr_system;charset=utf8mb4", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

class AdminLeaveController {
    private $db;
    private $baseURL = "/HrSystem/"; 

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function index() {
        if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'admin') {
            header("Location: " . $this->baseURL . "controllers/AuthController.php?action=loginView");
            exit();
        }

        $stmt = $this->db->prepare("
            SELECT l.*, e.name AS employee_name 
            FROM leaves l 
            LEFT JOIN employees e ON l.emp_id = e.id 
            ORDER BY l.id DESC
        ");
        $stmt->execute();
        $leaves = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($leaves)) {
            $_SESSION['message'] = "No leave requests found in the database.";
            $_SESSION['msg_type'] = "info";
        }

        $page_title = "Manage Leave Requests";
        ob_start();
        include __DIR__ . '/../views/leaves/admin_leave_list.php';
        $content = ob_get_clean();

        include __DIR__ . '/../public/MasterPage.php';
    }

public function updateStatus() {
    if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'admin') {
        header("Location: " . $this->baseURL . "controllers/AuthController.php?action=loginView");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $leave_id = $_POST['leave_id'] ?? null;
        $status = $_POST['status'] ?? null;

        if ($leave_id && in_array($status, ['approved', 'rejected'])) {
            $stmt = $this->db->prepare("SELECT status FROM leaves WHERE id = ?");
            $stmt->execute([$leave_id]);
            $leave = $stmt->fetch(PDO::FETCH_ASSOC);

            $currentStatus = strtolower($leave['status'] ?? '');

            if ($currentStatus === 'pending' || empty($currentStatus)) {
                $stmtUpdate = $this->db->prepare("UPDATE leaves SET status = ? WHERE id = ?");
                $stmtUpdate->execute([$status, $leave_id]);

                $_SESSION['message'] = "Leave request " . ($status === 'approved' ? 'approved' : 'rejected') . " successfully!";
                $_SESSION['msg_type'] = "success";
            } else {
                $_SESSION['message'] = "Action not allowed. Only pending requests can be updated.";
                $_SESSION['msg_type'] = "warning";
            }
        } else {
            $_SESSION['message'] = "Invalid request!";
            $_SESSION['msg_type'] = "danger";
        }

        header("Location: " . $this->baseURL . "controllers/AdminLeaveController.php?action=index");
        exit();
    }
}


}

$controller = new AdminLeaveController($db);

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'updateStatus':
        $controller->updateStatus();
        break;
    default:
        echo "Action not found!";
        break;
}