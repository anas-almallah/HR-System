<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = '127.0.0.1';
$dbname = 'hr_system';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

class DashboardController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        if (!isset($_SESSION['user_name']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header("Location: /HrSystem/controllers/AuthController.php?action=loginView");
            exit();
        }

        $pageTitle = "Dashboard";

        $tables = ['attendance', 'departments', 'employees', 'leaves', 'payroll', 'users'];
        $data = [];
        foreach ($tables as $table) {
            $stmt = $this->pdo->query("SELECT * FROM `$table`");
            $data[$table] = $stmt->fetchAll();
        }

        ob_start();
        include __DIR__ . "/../views/dashboard.php";
        $content = ob_get_clean();

        include __DIR__ . "/../public/MasterPage.php";
    }
}

$dashboardController = new DashboardController($pdo);
$action = $_GET['action'] ?? 'index';
if ($action === 'index') {
    $dashboardController->index();
}
?>
