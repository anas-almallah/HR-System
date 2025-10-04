<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Leave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-top: 3rem;
            max-width: 700px;
        }

        h2 {
            color: #1a3c6d;
            font-weight: 600;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #333;
        }

        .form-control,
        .form-control:focus {
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #1a3c6d;
            box-shadow: 0 0 8px rgba(26, 60, 109, 0.2);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .btn-primary {
            background-color: #1a3c6d;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #15315a;
        }

        .btn-outline-secondary {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            color: #1a3c6d;
            border-color: #1a3c6d;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background-color: #1a3c6d;
            color: #fff;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .table-borderless td {
            padding: 0.75rem 0;
        }
        body {
            background: url("/HrSystem/public/images/human-resources-hr-management-concept-vector.jpg") no-repeat center center;
            background-size: cover;
            background-attachment: fixed; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }


        @media (max-width: 576px) {
            .container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .btn-primary,
            .btn-outline-secondary {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <h2>Request Leave</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= htmlspecialchars($_SESSION['msg_type'] ?? 'success') ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php
                unset($_SESSION['message']);
                unset($_SESSION['msg_type']);
                ?>
            </div>
        <?php endif; ?>

        <form action="/HrSystem/controllers/LeaveController.php?action=store" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

            <table class="table table-borderless">
                <tr>
                    <td style="width: 30%;">
                        <label for="start_date" class="form-label">Start Date</label>
                    </td>
                    <td>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="end_date" class="form-label">End Date</label>
                    </td>
                    <td>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="reason" class="form-label">Reason</label>
                    </td>
                    <td>
                        <textarea class="form-control" id="reason" name="reason" rows="4" placeholder="Enter the reason for your leave..." required></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-end">
                        <button type="submit" class="btn btn-primary">Submit Leave</button>
                        <a href="/HrSystem/controllers/LeaveController.php?action=index" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-list me-1"></i> Back to Leave Requests
                        </a>
                        <a href="/HrSystem/controllers/AuthController.php?action=logout" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>