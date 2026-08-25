<?php
include '../../config/auth_check.php';
include '../../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $departmentId = (int) $_POST['department_id'];
    $departmentName = trim($_POST['department_name']);

    $stmt = $conn->prepare(
        "INSERT INTO departments (Department_ID, Department_Name) VALUES (?, ?)"
    );
    $stmt->bind_param("is", $departmentId, $departmentName);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    }

    $error = "Department could not be added. ID or name may already exist.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Department - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="mb-4">Add Department</h2>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Department ID</label>
                            <input type="number" name="department_id" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Department Name</label>
                            <input type="text" name="department_name" class="form-control" required>
                        </div>

                        <button class="btn btn-primary">Save Department</button>
                        <a href="index.php" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>