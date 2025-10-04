<?php
if (session_status() == PHP_SESSION_NONE) session_start();

// Base URL
$baseURL = "/HrSystem/";

// Create CSRF Token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Error & success messages
$error = $_SESSION['error'] ?? '';
$message = $_SESSION['message'] ?? '';
unset($_SESSION['error'], $_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: Arial; display:flex; justify-content:center; align-items:center; height:100vh; margin:0; background:#f0f2f5; }
        .login-container { background:white; padding:25px; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,0.1); width:320px; text-align:center; }
        .logo { width:100px; height:100px; background:radial-gradient(circle, #4a90e2, #63b3ed); border-radius:50%; margin:0 auto 20px; }
        h2 { margin:0 0 10px; color:#1c2526; }
        .error { color:red; font-size:13px; margin-bottom:10px; }
        .message { color:green; font-size:13px; margin-bottom:10px; }
        input { width:100%; padding:10px; margin:10px 0; border:none; border-bottom:1px solid #dddfe2; font-size:14px; box-sizing:border-box; }
        input:focus { outline:none; border-bottom:1px solid #4a90e2; }
        button { width:100%; padding:10px; background:#08005E; color:white; border:none; border-radius:4px; font-size:16px; cursor:pointer; }
        button:hover { background:#166fe5; }
        #togglePassword { position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; color:#888; }
        .password-wrapper { position:relative; margin-bottom:10px; }
                body {
            background: url("/HrSystem/public/images/human-resources-hr-management-concept-vector.jpg") no-repeat center center;
            background-size: cover;
            background-attachment: fixed; /* يخلي الخلفية ثابتة عند التمرير */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .logo {
    width: 100px;
    height: 100px;
    background: url("/HrSystem/public/images/1000_F_294542173_hgf8oIFGxUXZl28P9fEPujr1RHQenISK.jpg") no-repeat center center;
    background-size: cover;
    border-radius: 50px; 
}

    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo"></div>
        <h2>Login</h2>

        <?php if($error) echo "<div class='error'>$error</div>"; ?>
        <?php if($message) echo "<div class='message'>$message</div>"; ?>


<form method="POST" action="<?= $baseURL ?>controllers/AuthController.php?action=login">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="text" name="username" placeholder="Username" required>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i id="togglePassword" class="fa-regular fa-eye" aria-label="Toggle password visibility"></i>
            </div>
            <button type="submit" >Sign In</button>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
