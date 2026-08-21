<?php
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employeeId = (int) $_POST['employee_id'];
    $month = $_POST['month'];
    $basicSalary = (float) $_POST['basic_salary'];
    $deductions = (float) $_POST['deductions'];
    $netSalary = $basicSalary - $deductions;

    $maxIdResult = mysqli_query($conn, "SELECT IFNULL(MAX(Payroll_ID), 0) + 1 AS next_id FROM payroll");
    $nextId = mysqli_fetch_assoc($maxIdResult)['next_id'];

    $stmt = $conn->prepare("INSERT INTO payroll (Payroll_ID, Employee_ID, Month, Basic_Salary, Deductions, Net_Salary) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisddd", $nextId, $employeeId, $month, $basicSalary, $deductions, $netSalary);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

$employees = mysqli_query($conn, "SELECT Employee_ID, Name FROM employees ORDER BY Name");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Payroll - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Add Payroll</h2>
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
                <label>Month</label>
                <input type="text" name="month" class="form-control" placeholder="e.g. August 2026" required>
            </div>
            <div class="mb-3">
                <label>Basic Salary</label>
                <input type="number" step="0.01" name="basic_salary" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Deductions</label>
                <input type="number" step="0.01" name="deductions" class="form-control" value="0" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html> 