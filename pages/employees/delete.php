<?php
include '../../config/auth_check.php';
include '../../config/db.php';

if (isset($_GET['id'])) {
    $employeeId = (int) $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM employees WHERE Employee_ID = ?");
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();
}

header("Location: index.php");
exit;
?>