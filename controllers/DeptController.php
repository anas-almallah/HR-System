<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . "/../models/Department.php";

class DeptController {
    private $deptModel;

    public function __construct() {
if (!isset($_SESSION['user_name']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: /HrSystem/controllers/AuthController.php?action=loginView");
    exit();
}


        $this->deptModel = new Department();
    }

    public function index() {
        $departments = $this->deptModel->getAll();
        $pageTitle = "Departments";
        ob_start();
        include __DIR__ . "/../views/departments/list.php";
        $content = ob_get_clean();
        include __DIR__ . "/../public/MasterPage.php";
    }

    public function createView() {
        $pageTitle = "Add Department";
        ob_start();
        include __DIR__ . "/../views/departments/create.php";
        $content = ob_get_clean();
        include __DIR__ . "/../public/MasterPage.php";
    }

    public function create() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST['name']);
            if ($this->deptModel->create($name)) {
                $_SESSION['message'] = "Department created successfully!";
                $_SESSION['msg_type'] = "success";
            } else {
                $_SESSION['message'] = "Error while creating department!";
                $_SESSION['msg_type'] = "danger";
            }
            header("Location: DeptController.php?action=index");
            exit();
        }
    }

    public function editView($id) {
        $dept = $this->deptModel->getById($id);
        $pageTitle = "Edit Department";
        ob_start();
        include __DIR__ . "/../views/departments/edit.php";
        $content = ob_get_clean();
        include __DIR__ . "/../public/MasterPage.php";
    }

    public function edit($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST['name']);
            if ($this->deptModel->update($id, $name)) {
                $_SESSION['message'] = "Department updated successfully!";
                $_SESSION['msg_type'] = "success";
            } else {
                $_SESSION['message'] = "Error while updating department!";
                $_SESSION['msg_type'] = "danger";
            }
            header("Location: DeptController.php?action=index");
            exit();
        }
    }

    public function delete($id) {
        if ($this->deptModel->delete($id)) {
            $_SESSION['message'] = "Department deleted successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Error while deleting department!";
            $_SESSION['msg_type'] = "danger";
        }
        header("Location: DeptController.php?action=index");
        exit();
    }
}

$controller = new DeptController();
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case "createView": $controller->createView(); break;
    case "create": $controller->create(); break;
    case "editView": $controller->editView($id); break;
    case "edit": $controller->edit($id); break;
    case "delete": $controller->delete($id); break;
    default: $controller->index(); break;
}
