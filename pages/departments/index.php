<?php
include '../../config/auth_check.php';
include '../../config/db.php';

$search = $_GET['search'] ?? '';

if ($search !== '') {
    $value = "%$search%";
    $stmt = $conn->prepare(
        "SELECT * FROM departments
         WHERE Department_ID LIKE ? OR Department_Name LIKE ?
         ORDER BY Department_ID DESC"
    );
    $stmt->bind_param("ss", $value, $value);
    $stmt->execute();
    $departments = $stmt->get_result();
} else {
    $departments = $conn->query(
        "SELECT * FROM departments ORDER BY Department_ID DESC"
    );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Department Management - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Department Management</h2>
        <a href="add.php" class="btn btn-primary">Add Department</a>
    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-10">
            <input type="text" name="search" class="form-control"
                   placeholder="Search by Department ID or Name"
                   value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <div class="col-md-2">
            <button class="btn btn-success w-100">Search</button>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Department ID</th>
                        <th>Department Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($departments && $departments->num_rows > 0): ?>
                        <?php while ($row = $departments->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['Department_ID']; ?></td>
                                <td><?php echo htmlspecialchars($row['Department_Name']); ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $row['Department_ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete.php?id=<?php echo $row['Department_ID']; ?>" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Delete this department?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No department found.</td>
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