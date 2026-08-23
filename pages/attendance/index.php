<?php
include '../../config/auth_check.php';
include '../../config/db.php';

$sql = "SELECT attendance.Attendance_ID, attendance.Employee_ID, employees.Name, 
               attendance.Attendance_Date, attendance.Status
        FROM attendance
        LEFT JOIN employees ON attendance.Employee_ID = employees.Employee_ID
        ORDER BY attendance.Attendance_ID DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Management - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Attendance Management</h2>
        <a href="add.php" class="btn btn-primary mb-3">Add Attendance</a>

        <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Attendance ID</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['Attendance_ID']; ?></td>
                    <td><?php echo $row['Employee_ID']; ?></td>
                    <td><?php echo $row['Name']; ?></td>
                    <td><?php echo $row['Attendance_Date']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['Attendance_ID']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?php echo $row['Attendance_ID']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
</body>
</html>