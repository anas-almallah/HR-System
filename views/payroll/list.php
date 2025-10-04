<div class="container mt-5">
    <br>
    <br>
    <h2>Payroll</h2>
    <div class="mb-3">
    <a href="http://localhost/HrSystem/controllers/PayrollController.php?action=index" class="btn btn-primary">
        <i class="fa-solid fa-list"></i> Payroll List
    </a>

    <a href="http://localhost/HrSystem/controllers/PayrollController.php?action=create" class="btn btn-success">
        <i class="fa-solid fa-plus"></i> Add Payroll
    </a>
</div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee</th>
                <th>Month</th>
                <th>Basic Salary</th>
                <th>Allowances</th>
                <th>Deductions</th>
                <th>Net Salary</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($payrolls)): ?>
                <?php foreach ($payrolls as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['emp_name']) ?></td>
                        <td><?= htmlspecialchars($row['month']) ?></td>
                        <td><?= $row['basic_salary'] ?></td>
                        <td><?= $row['allowances'] ?></td>
                        <td><?= $row['deductions'] ?></td>
                        <td><?= $row['net_salary'] ?></td>
                        <td>
                            <a href="PayrollController.php?action=delete&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete payroll?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center">No payroll records found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
