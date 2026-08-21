<?php
include '../../config/db.php';

$sql = "SELECT leave_management.Leave_ID, leave_management.Employee_ID, employees.Name,
               leave_management.Leave_Type, leave_management.Start_Date, 
               leave_management.End_Date, leave_management.Status
        FROM leave_management
        LEFT JOIN employees ON leave_management.Employee_ID = employees.Employee_ID
        ORDER BY leave_management.Leave_ID DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Leave Management - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Leave Management</h2>
        <a href="add.php" class="btn btn-primary mb-3">Add Leave</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Leave ID</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['Leave_ID']; ?></td>
                    <td><?php echo $row['Employee_ID']; ?></td>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['Leave_Type']; ?></td>
                    <td><?php echo $row['Start_Date']; ?></td>
                    <td><?php echo $row['End_Date']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['Leave_ID']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?php echo $row['Leave_ID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>