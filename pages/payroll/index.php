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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payroll Management - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Payroll Management</h2>
        <a href="add.php" class="btn btn-primary mb-3">Add Payroll</a>

        <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Payroll ID</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Month</th>
                    <th>Basic Salary</th>
                    <th>Deductions</th>
                    <th>Net Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['Payroll_ID']; ?></td>
                    <td><?php echo $row['Employee_ID']; ?></td>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['Month']; ?></td>
                    <td><?php echo $row['Basic_Salary']; ?></td>
                    <td><?php echo $row['Deductions']; ?></td>
                    <td><?php echo $row['Net_Salary']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['Payroll_ID']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?php echo $row['Payroll_ID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
</body>
</html>