<?php
include '../../config/auth_check.php';
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employeeId = (int) $_POST['employee_id'];
    $date = $_POST['attendance_date'];
    $status = $_POST['status'];

    $maxIdResult = mysqli_query($conn, "SELECT IFNULL(MAX(Attendance_ID), 0) + 1 AS next_id FROM attendance");
    $nextId = mysqli_fetch_assoc($maxIdResult)['next_id'];

    $stmt = $conn->prepare("INSERT INTO attendance (Attendance_ID, Employee_ID, Attendance_Date, Status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $nextId, $employeeId, $date, $status);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

$employees = mysqli_query($conn, "SELECT Employee_ID, Name FROM employees ORDER BY Name");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Attendance - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Add Attendance</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Employee</label>
                <select name="employee_id" class="form-control" required>
                    <option value="">-- Select Employee --</option>
                    <?php while ($emp = mysqli_fetch_assoc($employees)) { ?>
                        <option value="<?php echo $emp['Employee_ID']; ?>">
                            <?php echo $emp['Employee_ID'] . ' - ' . $emp['Name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Date</label>
                <input type="date" name="attendance_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                    <option value="Leave">Leave</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>