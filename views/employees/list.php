<?php if(isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= $_SESSION['msg_type'] ?>">
        <?= $_SESSION['message']; unset($_SESSION['message']); unset($_SESSION['msg_type']); ?>
    </div>
<?php endif; ?>
<div class="container mt-5">
    <br>
    <br>
    <h2>Employee</h2>

<a href="EmployeeController.php?action=createView" class="btn btn-success mb-3">Add Employee</a>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Department</th>
        <th>salary</th>
        <th>Actions</th>
    </tr>
<?php foreach ($employees as $emp): ?>
    <tr>
        <td><?= $emp['id'] ?></td>
        <td><?= $emp['name'] ?></td>
        <td><?= $emp['email'] ?></td>
        <td><?= $emp['phone'] ?></td>
<td><?= $emp['dept_name'] ?></td>
        <td><?= $emp['salary'] ?></td>
        <td>
            <a href="EmployeeController.php?action=editView&id=<?= $emp['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
            <a href="javascript:void(0);" 
               onclick="if(confirm('Are you sure you want to delete this employee?')) { window.location='EmployeeController.php?action=delete&id=<?= $emp['id'] ?>'; }" 
               class="btn btn-danger btn-sm">Delete</a>
        </td>
    </tr>
<?php endforeach; ?>

</table>
    </div>