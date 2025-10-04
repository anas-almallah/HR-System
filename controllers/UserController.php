<?php
session_start();
include_once __DIR__ . '/../config/db.php';

class UserController {
    private $conn;

    public function __construct($db) {
        if (!isset($_SESSION['user_name']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header("Location: /HrSystem/controllers/AuthController.php?action=loginView");
            exit();
        }
        $this->conn = $db;
    }

    public function index() {
        $this->checkAdmin();

        $result = $this->conn->query("SELECT id, username, role FROM users ORDER BY id DESC");
        $users = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }

        ob_start();
        include __DIR__ . '/../views/auth/index.php';
        $content = ob_get_clean();
        $pageTitle = "All Users";
        include __DIR__ . '/../public/MasterPage.php';
    }

    private function checkAdmin() {
        if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'admin') {
            header("Location: AuthController.php?action=loginView");
            exit();
        }
    }
public function delete() {
    $this->checkAdmin();

    $id = $_GET['id'] ?? null;
    if (!$id) {
        $_SESSION['message'] = "Invalid user ID!";
        $_SESSION['msg_type'] = "danger";
        header("Location: UserController.php?action=index");
        exit();
    }

    $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "User deleted successfully!";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['msg_type'] = "danger";
    }

    header("Location: UserController.php?action=index");
    exit();
}

}

$action = $_GET['action'] ?? 'index';
$userController = new UserController($conn);

$allowedActions = ['index', 'createUserView', 'store', 'editView', 'update', 'delete'];

if (in_array($action, $allowedActions)) {
    $userController->$action();
} else {
    $userController->index();
}
