<?php
include '../../config/auth_check.php';
include '../../config/db.php';

$sql = "SELECT payroll.Payroll_ID, payroll.Employee_ID, employees.Name,
               payroll.Month, payroll.Basic_Salary, payroll.Deductions, payroll.Net_Salary
        FROM payroll
        LEFT JOIN employees ON payroll.Employee_ID = employees.Employee_ID
        ORDER BY payroll.Payroll_ID DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payroll Management - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Payroll Management</h2>
        <a href="add.php" class="btn btn-primary mb-3">Add Payroll</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Payroll ID</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Month</th>