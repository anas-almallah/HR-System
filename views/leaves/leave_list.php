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
    <title>My Leave Requests</title>
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
            max-width: 900px;
        }

        h2 {
            color: #1a3c6d;
            font-weight: 600;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: middle;
        }

        .table thead {
            background-color: #1a3c6d;
            color: #fff;
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
        body {
            background: url("/HrSystem/public/images/human-resources-hr-management-concept-vector.jpg") no-repeat center center;
            background-size: cover;
            background-attachment: fixed; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 1.5rem;
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
        <h2>My Leave Requests</h2>

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

        <div class="mb-3 text-end">
            <a href="?action=create" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Leave Request
            </a>
            <a href="/HrSystem/controllers/AuthController.php?action=logout" class="btn btn-outline-secondary ms-2">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>
        </div>

        <?php if (empty($leaves)): ?>
            <div class="alert alert-info text-center">
                No leave requests found.
            </div>
        <?php else: ?>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col">Reason</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($leaves as $leave): ?>
            <tr>
                <td><?= htmlspecialchars($leave['start_date']) ?></td>
                <td><?= htmlspecialchars($leave['end_date']) ?></td>
                <td><?= htmlspecialchars($leave['reason']) ?></td>
                <td>
                    <?php
                        $status = strtolower($leave['status'] ?? 'pending');
                        switch ($status) {
                            case 'approved':
                                $statusText = 'Approved';
                                $statusClass = 'text-success fw-bold';
                                break;
                            case 'rejected':
                                $statusText = 'Rejected';
                                $statusClass = 'text-danger fw-bold';
                                break;
                            default:
                                $statusText = 'Pending';
                                $statusClass = 'text-secondary fw-bold';
                                break;
                        }
                    ?>
                    <span class="<?= $statusClass ?>"><?= $statusText ?></span>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>