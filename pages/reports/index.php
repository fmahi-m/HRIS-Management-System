<?php
include '../../config/auth_check.php';
include '../../config/db.php';

// Employees per department
$employeeByDept = mysqli_query($conn,
    "SELECT departments.Department_Name, COUNT(employees.Employee_ID) AS total
     FROM departments
     LEFT JOIN employees ON employees.Department_ID = departments.Department_ID
     GROUP BY departments.Department_ID, departments.Department_Name
     ORDER BY departments.Department_Name"
);

// Attendance summary
$attendanceSummary = mysqli_query($conn,
    "SELECT Status, COUNT(*) AS total FROM attendance GROUP BY Status"
);

// Payroll summary
$payrollSummary = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total_records, IFNULL(SUM(Net_Salary), 0) AS total_net_salary FROM payroll"
));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reports - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Reports</h2>
        <a href="../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4>Employees by Department</h4>
            <table class="table table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Department</th>
                        <th>Total Employees</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($employeeByDept)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Department_Name']); ?></td>
                            <td><?php echo $row['total']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4>Attendance Summary</h4>
            <table class="table table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Status</th>
                        <th>Total Records</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($attendanceSummary)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Status']); ?></td>
                            <td><?php echo $row['total']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h4>Payroll Summary</h4>
            <p>Total Payroll Records: <?php echo $payrollSummary['total_records']; ?></p>
            <p>Total Net Salary Paid: <?php echo number_format($payrollSummary['total_net_salary'], 2); ?></p>
        </div>
    </div>
</div>
</body>
</html>