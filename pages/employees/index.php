<?php
include '../../config/db.php';

$search = $_GET['search'] ?? '';

if ($search !== '') {
    $searchValue = "%$search%";
    $stmt = $conn->prepare(
        "SELECT * FROM employees
         WHERE Employee_ID LIKE ?
         OR Name LIKE ?
         OR Department_ID LIKE ?
         ORDER BY Employee_ID DESC"
    );
    $stmt->bind_param("sss", $searchValue, $searchValue, $searchValue);
    $stmt->execute();
    $employees = $stmt->get_result();
} else {
    $employees = $conn->query(
        "SELECT * FROM employees ORDER BY Employee_ID DESC"
    );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Management - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Employee Management</h2>
        <a href="add.php" class="btn btn-primary">Add Employee</a>
    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-10">
            <input type="text" name="search" class="form-control"
                   placeholder="Search by Employee ID, Name or Department ID"
                   value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100">Search</button>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Department ID</th>
                            <th>Position</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($employees && $employees->num_rows > 0): ?>
                            <?php while ($row = $employees->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['Employee_ID']; ?></td>
                                    <td><?php echo htmlspecialchars($row['Name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Phone']); ?></td>
                                    <td><?php echo $row['Department_ID']; ?></td>
                                    <td><?php echo htmlspecialchars($row['Position']); ?></td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $row['Employee_ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete.php?id=<?php echo $row['Employee_ID']; ?>" class="btn btn-danger btn-sm"
                                           onclick="return confirm('Delete this employee?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No employee found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html> 