<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

session_unset();
session_destroy();

header("Location: http://localhost/HrSystem/controllers/AuthController.php?action=loginView");
exit();
