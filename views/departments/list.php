<h1>Departments</h1>

<?php if(isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= $_SESSION['msg_type'] ?>">
        <?= $_SESSION['message']; unset($_SESSION['message']); unset($_SESSION['msg_type']); ?>
    </div>
<?php endif; ?>
<div class="container mt-5">
    <h2>Department</h2>
<a href="DeptController.php?action=createView" class="btn btn-success mb-3">Add Department</a>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($departments as $dept): ?>
        <tr>
            <td><?= $dept['id'] ?></td>
            <td><?= $dept['name'] ?></td>
            <td>
                <a href="DeptController.php?action=editView&id=<?= $dept['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="javascript:void(0);" 
                   onclick="if(confirm('Are you sure you want to delete this department?')) { window.location='DeptController.php?action=delete&id=<?= $dept['id'] ?>'; }" 
                   class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
    </div>