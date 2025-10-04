<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . "/../models/Employee.php";
include_once __DIR__ . "/../models/User.php"; 

class EmployeeController {
    private $employeeModel;
    private $userModel;

    public function __construct() {
        if (!isset($_SESSION['user_name']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header("Location: /HrSystem/controllers/AuthController.php?action=loginView");
            exit();
        }

        $this->employeeModel = new Employee();
        $this->userModel = new User();
    }

    public function index() {
        $employees = $this->employeeModel->getAll();
        $pageTitle = "Employees";
        ob_start();
        include __DIR__ . "/../views/employees/list.php";
        $content = ob_get_clean();
        include __DIR__ . "/../public/MasterPage.php";
    }

    public function createView() {
        $departments = $this->employeeModel->getDepartments();
        $pageTitle = "Add Employee";
        ob_start();
        include __DIR__ . "/../views/employees/create.php";
        $content = ob_get_clean();
        include __DIR__ . "/../public/MasterPage.php";
    }

    public function create() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $dept_id = intval($_POST['dept_id']);
            $salary = floatval($_POST['salary']);

            if ($this->employeeModel->create($name, $email, $phone, $dept_id, $salary)) {
                $this->userModel->create($name, $name, 'employee'); 

                $_SESSION['message'] = "Employee created successfully!";
                $_SESSION['msg_type'] = "success";
            } else {
                $_SESSION['message'] = "Error creating employee!";
                $_SESSION['msg_type'] = "danger";
            }
            header("Location: EmployeeController.php?action=index");
            exit();
        }
    }

    public function editView($id) {
        $employee = $this->employeeModel->getById($id);
        $departments = $this->employeeModel->getDepartments();
        $pageTitle = "Edit Employee";
        ob_start();
        include __DIR__ . "/../views/employees/edit.php";
        $content = ob_get_clean();
        include __DIR__ . "/../public/MasterPage.php";
    }

    public function edit($id) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $dept_id = intval($_POST['dept_id']);
            $salary = floatval($_POST['salary']);

            $oldEmployee = $this->employeeModel->getById($id);
            $oldName = $oldEmployee['name'] ?? '';

            if ($this->employeeModel->update($id, $name, $email, $phone, $dept_id, $salary)) {
                $this->userModel->updateUsername($oldName, $name);

                $_SESSION['message'] = "Employee updated successfully!";
                $_SESSION['msg_type'] = "success";
            } else {
                $_SESSION['message'] = "Error updating employee!";
                $_SESSION['msg_type'] = "danger";
            }
            header("Location: EmployeeController.php?action=index");
            exit();
        }
    }

    public function delete($id) {
        $employee = $this->employeeModel->getById($id);
        $name = $employee['name'] ?? '';

        if ($this->employeeModel->delete($id)) {
            if ($name) {
                $this->userModel->deleteByUsername($name);
            }

            $_SESSION['message'] = "Employee deleted successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Error deleting employee!";
            $_SESSION['msg_type'] = "danger";
        }
        header("Location: EmployeeController.php?action=index");
        exit();
    }
}

$controller = new EmployeeController();
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case "createView":
        $controller->createView();
        break;
    case "create":
        $controller->create();
        break;
    case "editView":
        $controller->editView($id);
        break;
    case "edit":
        $controller->edit($id);
        break;
    case "delete":
        $controller->delete($id);
        break;
    default:
        $controller->index();
        break;
}
