<div class="container mt-5">
    <br>
    <br>
    <h2 class="mb-4">Add Employee</h2>
    <form method="POST" action="EmployeeController.php?action=create">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Department</label>
            <select name="dept_id" class="form-control" required>
                <option value="">-- Select Department --</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?= $dept['id'] ?>"><?= $dept['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Salary</label>
            <input type="number" name="salary" class="form-control" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="EmployeeController.php?action=index" class="btn btn-primary">Cancel</a>
    </form>
</div>
