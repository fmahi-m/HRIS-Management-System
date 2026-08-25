<?php
include '../../config/auth_check.php';
include '../../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$employeeId = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM employees WHERE Employee_ID = ?");
$stmt->bind_param("i", $employeeId);
$stmt->execute();
$employee = $stmt->get_result()->fetch_assoc();

if (!$employee) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $departmentId = $_POST['department_id'] === '' ? null : (int) $_POST['department_id'];
    $position = trim($_POST['position']);

    $stmt = $conn->prepare(
        "UPDATE employees
         SET Name = ?, Email = ?, Phone = ?, Department_ID = ?, Position = ?
         WHERE Employee_ID = ?"
    );

    $stmt->bind_param(
        "sssisi",
        $name,
        $email,
        $phone,
        $departmentId,
        $position,
        $employeeId
    );

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Employee could not be updated.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Employee - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="mb-4">Edit Employee</h2>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Employee ID</label>
                            <input type="number" class="form-control"
                                   value="<?php echo $employee['Employee_ID']; ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required
                                   value="<?php echo htmlspecialchars($employee['Name']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required
                                   value="<?php echo htmlspecialchars($employee['Email']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" required
                                   value="<?php echo htmlspecialchars($employee['Phone']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Department ID (optional)</label>
                            <input type="number" name="department_id" class="form-control"
                                   value="<?php echo htmlspecialchars($employee['Department_ID'] ?? ''); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Position</label>
                            <input type="text" name="position" class="form-control" required
                                   value="<?php echo htmlspecialchars($employee['Position']); ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Employee</button>
                        <a href="index.php" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>