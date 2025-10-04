<h1>Dashboard</h1>

<?php if(isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= $_SESSION['msg_type'] ?>">
        <?= $_SESSION['message']; unset($_SESSION['message']); unset($_SESSION['msg_type']); ?>
    </div>
<?php endif; ?>

<div class="container mt-5">

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="alert alert-info">
                <strong>Total Employees:</strong> <?= count($data['employees']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-success">
                <strong>Total Salary:</strong> <?= array_sum(array_column($data['employees'], 'salary')) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-warning">
                <strong>Total Departments:</strong> <?= count($data['departments']) ?>
            </div>
        </div>
    </div>

    <h2>Departments</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        <?php foreach ($data['departments'] as $dept): ?>
            <tr>
                <td><?= $dept['id'] ?></td>
                <td><?= $dept['name'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Employees</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Salary</th>
        </tr>
        <?php foreach ($data['employees'] as $emp): ?>
            <tr>
                <td><?= $emp['id'] ?></td>
                <td><?= $emp['name'] ?></td>
                <td><?= $emp['email'] ?></td>
                <td><?= $emp['phone'] ?></td>
                <td><?= $emp['dept_id'] ?></td>
                <td><?= $emp['salary'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Attendance</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Employee ID</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php foreach ($data['attendance'] as $att): ?>
            <tr>
                <td><?= $att['id'] ?></td>
                <td><?= $att['emp_id'] ?></td>
                <td><?= $att['date'] ?></td>
                <td><?= $att['status'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Leaves</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Employee ID</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            <th>Status</th>
        </tr>
        <?php foreach ($data['leaves'] as $leave): ?>
            <tr>
                <td><?= $leave['id'] ?></td>
                <td><?= $leave['emp_id'] ?></td>
                <td><?= $leave['start_date'] ?></td>
                <td><?= $leave['end_date'] ?></td>
                <td><?= $leave['reason'] ?></td>
                <td><?= $leave['status'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Payroll</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Employee ID</th>
            <th>Month</th>
            <th>Basic Salary</th>
            <th>Allowances</th>
            <th>Deductions</th>
            <th>Net Salary</th>
        </tr>
        <?php foreach ($data['payroll'] as $pay): ?>
            <tr>
                <td><?= $pay['id'] ?></td>
                <td><?= $pay['emp_id'] ?></td>
                <td><?= $pay['month'] ?></td>
                <td><?= $pay['basic_salary'] ?></td>
                <td><?= $pay['allowances'] ?></td>
                <td><?= $pay['deductions'] ?></td>
                <td><?= $pay['net_salary'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Users</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
        </tr>
        <?php foreach ($data['users'] as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['role'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>
