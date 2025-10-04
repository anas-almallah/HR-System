

<div class="container mt-5">
<br>
<br>
<h2 class="mb-4">Add Department</h2>
<form method="POST" action="DeptController.php?action=create">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Save</button>
    <a href="DeptController.php?action=index" class="btn btn-primary">Cancel</a>
</form>
</div>