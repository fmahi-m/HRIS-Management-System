<?php
include '../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$departmentId = (int) $_GET['id'];

$stmt = $conn->prepare(
    "SELECT * FROM departments WHERE Department_ID = ?"
);
$stmt->bind_param("i", $departmentId);
$stmt->execute();
$department = $stmt->get_result()->fetch_assoc();

if (!$department) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $departmentName = trim($_POST['department_name']);

    $stmt = $conn->prepare(
        "UPDATE departments SET Department_Name = ? WHERE Department_ID = ?"
    );
    $stmt->bind_param("si", $departmentName, $departmentId);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    }

    $error = "Department could not be updated.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Department - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="mb-4">Edit Department</h2>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Department ID</label>
                            <input type="number" class="form-control"
                                   value="<?php echo $department['Department_ID']; ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Department Name</label>
                            <input type="text" name="department_name" class="form-control" required
                                   value="<?php echo htmlspecialchars($department['Department_Name']); ?>">
                        </div>

                        <button class="btn btn-primary">Update Department</button>
                        <a href="index.php" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html> 