<?php
include '../../config/auth_check.php';
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
                        <option value="<?php echo $emp['Employee_ID'];