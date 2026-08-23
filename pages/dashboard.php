<?php
include '../config/auth_check.php';
include '../config/db.php';

$totalEmployees = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM employees"))['total'];
$totalDepartments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM departments"))['total'];
$todayPresent = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM attendance WHERE Attendance_Date = CURDATE() AND Status = 'Present'"))['total'];
$monthlyPayroll = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(Net_Salary), 0) AS total FROM payroll"))['total'];
?>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h2 class="mb-2 mb-md-0">HRIS Dashboard</h2>
        <div>
            <a href="reports/index.php" class="btn btn-outline-primary">Reports</a>
            <a href="logout.php" class="btn btn-outline-danger">Logout</a>
        </div>
    </div>

<div class="row">


<div class="col-md-3">

<div class="card text-center p-3">

<h5>Employee</h5>

<p>Total Employees: <?php echo $totalEmployees; ?></p>

<a href="employees/index.php" class="btn btn-primary">
View
</a>

</div>

</div>



<div class="col-md-3">

<div class="card text-center p-3">

<h5>Department</h5>

<p>Total Departments: <?php echo $totalDepartments; ?></p>

<a href="departments/index.php" class="btn btn-success">
View
</a>

</div>

</div>



<div class="col-md-3">

<div class="card text-center p-3">

<h5>Attendance</h5>

<p>Present Today: <?php echo $todayPresent; ?></p>

<a href="attendance/index.php" class="btn btn-warning">
View
</a>

</div>

</div>



<div class="col-md-3">

<div class="card text-center p-3">

<h5>Payroll</h5>

<p>Total Net Salary: <?php echo number_format($monthlyPayroll, 2); ?></p>

<a href="payroll/index.php" class="btn btn-danger">
View
</a>

</div>

</div>


</div>

</div>