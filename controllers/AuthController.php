<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include_once __DIR__ . "/../models/User.php";

class AuthController {
    private $userModel;
    private $baseURL;

    public function __construct() {
        $this->userModel = new User();
        $this->baseURL = "/HrSystem/";
    }

public function createUserView() {
    if (!isset($_SESSION['user_name']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: /HrSystem/controllers/AuthController.php?action=loginView");
    exit();
}

    $pageTitle = "Create New User";

    ob_start();
    include __DIR__ . "/../views/auth/create.php";
    $content = ob_get_clean();

    include __DIR__ . "/../../public/MasterPage.php";
}


    public function createUser() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION['error'] = "Invalid request method!";
            header("Location: " . $this->baseURL . "controllers/AuthController.php?action=createUserView");
            exit();
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error'] = "Invalid CSRF token!";
            header("Location: " . $this->baseURL . "controllers/AuthController.php?action=createUserView");
            exit();
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'user';

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "All fields are required!";
            header("Location: " . $this->baseURL . "controllers/AuthController.php?action=createUserView");
            exit();
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        if ($this->userModel->create($username, $passwordHash, $role)) {
            $_SESSION['message'] = "Account created successfully!";
            header("Location: " . $this->baseURL . "controllers/AuthController.php?action=loginView");
            exit();
        } else {
            $_SESSION['error'] = "Failed to create account! Username may already exist.";
            header("Location: " . $this->baseURL . "controllers/AuthController.php?action=createUserView");
            exit();
        }
    }

    public function loginView() {
        include __DIR__ . "/../views/auth/login.php";
    }

public function login() {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: " . $this->baseURL . "controllers/AuthController.php?action=loginView");
        exit();
    }

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token!";
        header("Location: " . $this->baseURL . "controllers/AuthController.php?action=loginView");
        exit();
    }

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = $this->userModel->findUser($username);

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_name'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id']; 

if ($user['role'] === 'admin') {
    header("Location: " . $this->baseURL . "controllers/DashboardController.php?action=index");
    exit();
} else { 
    header("Location: " . $this->baseURL . "controllers/LeaveController.php?action=create");
    exit();
}

    } else {
        $_SESSION['error'] = "Incorrect username or password!";
        header("Location: " . $this->baseURL . "controllers/AuthController.php?action=loginView");
        exit();
    }
}


    public function logout() {
        session_destroy();
        header("Location: " . $this->baseURL . "controllers/AuthController.php?action=loginView");
        exit();
    }
}

$authController = new AuthController();
$action = $_GET['action'] ?? 'loginView';
$allowedActions = ['createUserView', 'createUser', 'loginView', 'login', 'logout'];

if (in_array($action, $allowedActions)) {
    $authController->$action();
} else {
    $authController->loginView();
}
?>