<div class="container mt-5">
    <br>
    <br>
    <h2>Monthly Attendance Report</h2>

    <form method="GET" class="mb-3">
        <input type="hidden" name="action" value="reportView">
        <div class="row">
            <div class="col-md-3">
                <label>Department</label>
                <select name="dept_id" class="form-control">
                    <option value="0">-- All Departments --</option>
                    <?php foreach($departments as $dept): ?>
                        <option value="<?= htmlspecialchars($dept['id']) ?>" <?= ($dept_id == $dept['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dept['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label>Month</label>
                <input type="number" name="month" class="form-control" min="1" max="12" value="<?= $month ?>">
            </div>
            <div class="col-md-2">
                <label>Year</label>
                <input type="number" name="year" class="form-control" min="2000" max="2100" value="<?= $year ?>">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Present Days</th>
                <th>Absent Days</th>
                <th>Total Days</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($report)): ?>
                <?php foreach($report as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td><?= $r['present_days'] ?></td>
                    <td><?= $r['absent_days'] ?></td>
                    <td><?= $r['present_days'] + $r['absent_days'] ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No records found. Check if data exists for the selected month/year.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>