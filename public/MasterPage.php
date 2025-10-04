<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';

$baseURL = "/HrSystem/public/"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo isset($pageTitle) ? $pageTitle : "Dashboard"; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    
    <link rel="icon" href="<?php echo $baseURL; ?>img/logo.png" type="image/x-icon" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo $baseURL; ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo $baseURL; ?>assets/css/plugins.min.css" />
    <link rel="stylesheet" href="<?php echo $baseURL; ?>assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="<?php echo $baseURL; ?>assets/css/demo.css" />

    <style>
        nav, .sidebar-logo, .sidebar-wrapper, .nav-toggle, .logo-header {
            background-color: #08005E;
            color: white;
        }

        .main-header {
            background-color: #F5F7FD;
        } 

        nav i, .sidebar-wrapper i, .nav-toggle i, .sidebar-logo i, .logo-header i, a i {
            color: white !important;
        }

        nav p, .sidebar-wrapper p, .nav-toggle p, .sidebar-logo p, .logo-header p {
            color: white;
        }

        .logo-img { filter: brightness(0) invert(1); height: 25px; }
        .icon-large { font-size: 22px; }
        .social-plus-text { color: white; font-size: 20px; font-weight: bold; margin-left: 10px; }
        .collapse span, a, li, i, p, span::before { color: white; }
        #logout { display: flex; align-items: center; gap: 12px; color:white; text-decoration:none; padding-left:30px; }
        .social-plus-text-1 { color: white; margin-left: 10px; }
        #userphoto { border-radius: 50%; margin-left: -7px; }
        #userim { padding-left: 10px; }
        html { overflow: auto; }
        
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-header d-flex justify-content-between align-items-center w-100">
                <a href="<?php echo $baseURL; ?>../index.php?action=list" class="logo d-flex align-items-center text-white text-decoration-none">
                    <span class="social-plus-text d-none d-md-inline">HR Navigator</span>
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                    <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
                </div>
            </div>
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <ul class="nav nav-secondary">
                    <li class="nav-item">
                        <a href="#">
                            <i class="fa-solid fa-circle-user"></i>
                            <p id="userim"><?php echo $userName; ?></p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="http://localhost/HrSystem/controllers/DashboardController.php?action=index"><i class="fa-solid fa-gauge-high"></i><p>Dashboard</p></a>
                    </li>
                    <?php if ($role === "admin") { ?>
                        <li class="nav-item"><a href="http://localhost/HrSystem/controllers/UserController.php?action=index"><i class="fa-solid fa-users-gear"></i><p>Manage Users</p></a></li>
                    <?php } ?>
                    <li class="nav-item">
                        <a href="http://localhost/HrSystem/controllers/EmployeeController.php?action=index"><i class="fa-solid fa-users"></i><p>Employees</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="http://localhost/HrSystem/controllers/DeptController.php?action=index"><i class="fa-regular fa-building"></i><p>Departments</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="http://localhost/HrSystem/controllers/AttendanceController.php"><i class="fa-solid fa-clipboard-user"></i><p>Attendance</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="http://localhost//HrSystem/controllers/AdminLeaveController.php?action=index"><i class="fa-solid fa-arrow-right-to-city"></i><p>Leaves</p></a>
                    </li>
                    <li class="nav-item">
                        <a href="http://localhost/HrSystem/controllers/PayrollController.php?action=index"><i class="fa-solid fa-wallet"></i><p>Payroll</p></a>
                    </li>
                    <li class="nav-item">
                            <a href="/HrSystem/controllers/AuthController.php?action=logout"><i class="fa-solid fa-right-from-bracket"></i><p>Logout</p></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Panel -->
    <div class="main-panel">
        <div class="main-header"></div>

        <!-- Page Content -->
        <div class="content">
            <?php
            if(isset($_SESSION['message'])) {
                echo '<div class="alert alert-'.$_SESSION['msg_type'].'">'.$_SESSION['message'].'</div>';
                unset($_SESSION['message']);
            }

            if (isset($content)) {
                echo $content;
            }
            ?>
        </div>
    </div>
</div>

<!-- JS Files -->
<script src="<?php echo $baseURL; ?>assets/js/core/jquery-3.7.1.min.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/core/popper.min.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/core/bootstrap.min.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/kaiadmin.min.js"></script>
</body>
</html>
