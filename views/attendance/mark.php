<div class="container mt-5">
    <br>
    <br>
    <h2>Mark Attendance</h2>

    <a href="http://localhost/HrSystem/controllers/AttendanceController.php?action=reportView" class="btn btn-primary mb-3">View Monthly Report</a>

    <div class="mb-3">
        <label>Department</label>
        <select id="deptSelect" class="form-control">
            <option value="">-- Select Department --</option>
            <?php if (!empty($departments)): ?>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?= htmlspecialchars($dept['id']) ?>"><?= htmlspecialchars($dept['name']) ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>

    <table class="table table-bordered mt-3" id="employeeList">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Present Days</th>
                <th>Absent Days</th>
                <th>Total Days</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" class="text-center">Select a department to view employees</td>
            </tr>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {

    function loadEmployees(dept_id) {
        if (!dept_id) {
            $('#employeeList tbody').html('<tr><td colspan="5" class="text-center">Select a department to view employees</td></tr>');
            return;
        }

        $.ajax({
            url: 'http://localhost/HrSystem/controllers/AttendanceController.php?action=getEmployeesByDept&dept_id=' + dept_id,
            type: 'GET',
            dataType: 'json',
            success: function(employees) {
                if (!employees || employees.length === 0) {
                    $('#employeeList tbody').html('<tr><td colspan="5" class="text-center">No employees found</td></tr>');
                    return;
                }

                let html = '';
                employees.forEach(emp => {
                    let total_days = parseInt(emp.present_days) + parseInt(emp.absent_days);
                    html += `<tr>
                                <td>${emp.name}</td>
                                <td>${emp.present_days}</td>
                                <td>${emp.absent_days}</td>
                                <td>${total_days}</td>
                                <td>
                                    <button class="btn btn-success btn-sm mark-btn" data-id="${emp.id}" data-status="Present">Present</button>
                                    <button class="btn btn-danger btn-sm mark-btn" data-id="${emp.id}" data-status="Absent">Absent</button>
                                </td>
                             </tr>`;
                });
                $('#employeeList tbody').html(html);
            },
            error: function(xhr, status, error) {
                console.error("Error loading employees:", status, error);
                $('#employeeList tbody').html('<tr><td colspan="5" class="text-center">Error loading employees</td></tr>');
            }
        });
    }

    $('#deptSelect').on('change', function() {
        let dept_id = $(this).val();
        loadEmployees(dept_id);
    });

    $(document).on('click', '.mark-btn', function() {
        let emp_id = $(this).data('id');
        let status = $(this).data('status');
        let dept_id = $('#deptSelect').val();

        $.ajax({
            url: 'http://localhost/HrSystem/controllers/AttendanceController.php?action=mark',
            type: 'POST',
            dataType: 'json',
            data: { emp_id: emp_id, status: status },
            success: function(result) {
                if (result.success) {
                    alert('Attendance marked successfully!');
                    loadEmployees(dept_id);
                } else {
                    alert(result.message || 'Error marking attendance');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error marking attendance:", status, error);
                alert("Error connecting to server: " + error);
            }
        });
    });

});
</script>
