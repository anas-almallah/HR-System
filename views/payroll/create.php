<div class="container mt-5">
    <br>
    <br>
    <h2>Add Payroll</h2>

    <div class="mb-3">
        <a href="PayrollController.php?action=index" class="btn btn-primary">
            <i class="fa-solid fa-list"></i> Payroll List
        </a>
    </div>

    <form method="POST" action="PayrollController.php?action=store">
        <div class="mb-3">
            <label for="dept_id" class="form-label">Department</label>
            <select name="dept_id" id="dept_id" class="form-control" required>
                <option value="">-- Select Department --</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="emp_id" class="form-label">Employee</label>
            <select name="emp_id" id="emp_id" class="form-control" required>
                <option value="">-- Select Employee --</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="month" class="form-label">Month</label>
            <input type="month" name="month" id="month" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="basic_salary" class="form-label">Basic Salary</label>
            <input type="number" step="0.01" name="basic_salary" id="basic_salary" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label for="allowances" class="form-label">Allowances</label>
            <input type="number" step="0.01" name="allowances" id="allowances" class="form-control">
        </div>

        <div class="mb-3">
            <label for="deductions" class="form-label">Deductions</label>
            <input type="number" step="0.01" name="deductions" id="deductions" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save Payroll</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {

    function loadEmployees(dept_id) {
        if (!dept_id) {
            $('#emp_id').html('<option value="">-- Select Employee --</option>');
            $('#basic_salary').val('');
            return;
        }

        $.ajax({
            url: 'http://localhost/HrSystem/controllers/PayrollController.php?action=getEmployeesByDept&dept_id=' + dept_id,
            type: 'GET',
            dataType: 'json',
            success: function(employees) {
                let html = '<option value="">-- Select Employee --</option>';
                if (employees.length > 0) {
                    employees.forEach(emp => {
                        html += `<option value="${emp.id}" data-salary="${emp.salary}">${emp.name} (Salary: ${emp.salary})</option>`;
                    });
                } else {
                    html = '<option value="">No employees found</option>';
                }
                $('#emp_id').html(html);
                $('#basic_salary').val('');   
            },
            error: function(xhr, status, error) {
                console.error("Error loading employees:", error);
                $('#emp_id').html('<option value="">Error loading employees</option>');
                $('#basic_salary').val('');
            }
        });
    }

    $('#dept_id').on('change', function() {
        let dept_id = $(this).val();
        loadEmployees(dept_id);
    });

    $('#emp_id').on('change', function() {
        let salary = $(this).find(':selected').data('salary') || 0;
        $('#basic_salary').val(salary);
    });

});
</script>
