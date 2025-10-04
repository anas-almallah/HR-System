<div class="container mt-5">
    <br><br>
    <h2 class="mb-4">Edit Employee</h2>

    <form method="POST" action="EmployeeController.php?action=edit&id=<?= $employee['id'] ?>" style="max-width: 500px;">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" value="<?= $employee['name'] ?>" class="form-control" style="border-radius: 0;" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" value="<?= $employee['email'] ?>" class="form-control" style="border-radius: 0;" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" id="phone" name="phone" value="<?= $employee['phone'] ?>" class="form-control" style="border-radius: 0;" required>
        </div>

        <div class="mb-3">
            <label for="department_id" class="form-label">Department</label>
<select name="dept_id" class="form-control" required>
    <option value="">-- Select Department --</option>
    <?php foreach ($departments as $dept): ?>
        <option value="<?= $dept['id'] ?>" <?= $employee['dept_id'] == $dept['id'] ? 'selected' : '' ?>>
            <?= $dept['name'] ?>
        </option>
    <?php endforeach; ?>
</select>

        </div>

        <div class="mb-3">
            <label for="salary" class="form-label">Salary</label>
            <input type="number" id="salary" name="salary" value="<?= $employee['salary'] ?>" class="form-control" style="border-radius: 0;" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="EmployeeController.php?action=index" class="btn btn-primary">Cancel</a>
    </form>
</div>
