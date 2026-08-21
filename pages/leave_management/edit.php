<?php
include '../../config/db.php';

$id = (int) $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employeeId = (int) $_POST['employee_id'];
    $leaveType = $_POST['leave_type'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE leave_management SET Employee_ID=?, Leave_Type=?, Start_Date=?, End_Date=?, Status=? WHERE Leave_ID=?");
    $stmt->bind_param("issssi", $employeeId, $leaveType, $startDate, $endDate, $status, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM leave_management WHERE Leave_ID=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$leave = $stmt->get_result()->fetch_assoc();

$employees = mysqli_query($conn, "SELECT Employee_ID, Name FROM employees ORDER BY Name");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Leave - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Edit Leave</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Employee</label>
                <select name="employee_id" class="form-control" required>
                    <?php while ($emp = mysqli_fetch_assoc($employees)) { ?>
                        <option value="<?php echo $emp['Employee_ID']; ?>"
                            <?php echo ($emp['Employee_ID'] == $leave['Employee_ID']) ? 'selected' : ''; ?>>
                            <?php echo $emp['Employee_ID'] . ' - ' . $emp['Name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Leave Type</label>
                <select name="leave_type" class="form-control" required>
                    <?php foreach (['Sick', 'Casual', 'Annual'] as $opt) { ?>
                        <option value="<?php echo $opt; ?>"
                            <?php echo ($opt == $leave['Leave_Type']) ? 'selected' : ''; ?>>
                            <?php echo $opt; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control"
                       value="<?php echo $leave['Start_Date']; ?>" required>
            </div>
            <div class="mb-3">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control"
                       value="<?php echo $leave['End_Date']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <?php foreach (['Pending', 'Approved', 'Rejected'] as $opt) { ?>
                        <option value="<?php echo $opt; ?>"
                            <?php echo ($opt == $leave['Status']) ? 'selected' : ''; ?>>
                            <?php echo $opt; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>