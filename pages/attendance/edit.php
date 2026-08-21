<?php
include '../../config/db.php';

$id = (int) $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employeeId = (int) $_POST['employee_id'];
    $date = $_POST['attendance_date'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE attendance SET Employee_ID=?, Attendance_Date=?, Status=? WHERE Attendance_ID=?");
    $stmt->bind_param("issi", $employeeId, $date, $status, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM attendance WHERE Attendance_ID=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$attendance = $stmt->get_result()->fetch_assoc();

$employees = mysqli_query($conn, "SELECT Employee_ID, Name FROM employees ORDER BY Name");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Attendance - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Edit Attendance</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Employee</label>
                <select name="employee_id" class="form-control" required>
                    <?php while ($emp = mysqli_fetch_assoc($employees)) { ?>
                        <option value="<?php echo $emp['Employee_ID']; ?>"
                            <?php echo ($emp['Employee_ID'] == $attendance['Employee_ID']) ? 'selected' : ''; ?>>
                            <?php echo $emp['Employee_ID'] . ' - ' . $emp['Name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Date</label>
                <input type="date" name="attendance_date" class="form-control"
                       value="<?php echo $attendance['Attendance_Date']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <?php foreach (['Present', 'Absent', 'Leave'] as $opt) { ?>
                        <option value="<?php echo $opt; ?>"
                            <?php echo ($opt == $attendance['Status']) ? 'selected' : ''; ?>>
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