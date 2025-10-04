
<div class="container mt-5">
    <br>
    <br>
    <h2>Users</h2>

    <?php if(!empty($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['msg_type'] ?? 'info' ?>">
            <?= $_SESSION['message']; ?>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['msg_type']); ?>
    <?php endif; ?>

    <div class="mb-3">
<a href="EmployeeController.php?action=createView" class="btn btn-success mb-3">Add New User</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($users)): ?>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center">No users found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>