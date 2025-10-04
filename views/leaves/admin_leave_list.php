<div class="container mt-4">
    <h2>Manage Leave Requests</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_SESSION['msg_type'] ?? 'success') ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php
            unset($_SESSION['message']);
            unset($_SESSION['msg_type']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (empty($leaves)): ?>
        <p>No leave requests found.</p>
    <?php else: ?>
    <br>
    <h2>Employee</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th scope="col">Request ID</th>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaves as $leave): ?>
                    <tr>
                        <td><?= htmlspecialchars($leave['id']) ?></td>
                        <td><?= htmlspecialchars($leave['employee_name'] ?? 'Unknown') ?></td>
                        <td><?= htmlspecialchars($leave['start_date']) ?></td>
                        <td><?= htmlspecialchars($leave['end_date']) ?></td>
                        <td><?= htmlspecialchars($leave['reason']) ?></td>
                        <td>
                            <?php
                                $status = strtolower($leave['status'] ?? 'pending');
                                switch ($status) {
                                    case 'approved':
                                        $statusText = 'Approved';
                                        $statusClass = 'text-success fw-bold';
                                        break;
                                    case 'rejected':
                                        $statusText = 'Rejected';
                                        $statusClass = 'text-danger fw-bold';
                                        break;
                                    default:
                                        $statusText = 'Pending';
                                        $statusClass = 'text-secondary fw-bold';
                                        break;
                                }
                            ?>
                            <span class="<?= $statusClass ?>"><?= $statusText ?></span>
                        </td>
                        <td>
                            <?php if ($status === 'pending'): ?>
                                <form action="/HrSystem/controllers/AdminLeaveController.php?action=updateStatus" method="POST" style="display:inline;">
                                    <input type="hidden" name="leave_id" value="<?= $leave['id'] ?>">
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check me-1"></i> Approve
                                    </button>
                                </form>
                                <form action="/HrSystem/controllers/AdminLeaveController.php?action=updateStatus" method="POST" style="display:inline;">
                                    <input type="hidden" name="leave_id" value="<?= $leave['id'] ?>">
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-danger btn-sm ms-2">
                                        <i class="fas fa-times me-1"></i> Reject
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted">No actions available</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
