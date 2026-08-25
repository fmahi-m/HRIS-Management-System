<?php
include '../../config/auth_check.php';
include '../../config/db.php';

$id = (int) $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employeeId = (int) $_POST['employee_id'];
    $month = $_POST['month'];
    $basicSalary = (float) $_POST['basic_salary'];
    $deductions = (float) $_POST['deductions'];
    $netSalary = $basicSalary - $deductions;

    $stmt = $conn->prepare("UPDATE payroll SET Employee_ID=?, Month=?, Basic_Salary=?, Deductions=?, Net_Salary=? WHERE Payroll_ID=?");
    $stmt->bind_param("isdddi", $employeeId, $month, $basicSalary, $deductions, $netSalary, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM payroll WHERE Payroll_ID=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$payroll = $stmt->get_result()->fetch_assoc();

$employees = mysqli_query($conn, "SELECT Employee_ID, Name FROM employees ORDER BY Name");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Payroll - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Edit Payroll</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Employee</label>
                <select name="employee_id" class="form-control" required>
                    <?php while ($emp = mysqli_fetch_assoc($employees)) { ?>
                        <option value="<?php echo $emp['Employee_ID']; ?>"
                            <?php echo ($emp['Employee_ID'] == $payroll['Employee_ID']) ? 'selected' : ''; ?>>
                            <?php echo $emp['Employee_ID'] . ' - ' . $emp['Name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Month</label>
                <input type="text" name="month" class="form-control"
                       value="<?php echo $payroll['Month']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Basic Salary</label>
                <input type="number" step="0.01" name="basic_salary" class="form-control"
                       value="<?php echo $payroll['Basic_Salary']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Deductions</label>
                <input type="number" step="0.01" name="deductions" class="form-control"
                       value="<?php echo $payroll['Deductions']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>