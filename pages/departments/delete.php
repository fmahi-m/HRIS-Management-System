<?php
include '../../config/auth_check.php';
include '../../config/db.php';

if (isset($_GET['id'])) {
    $departmentId = (int) $_GET['id'];

    // Remove department reference from employees
    $stmt = $conn->prepare(
        "UPDATE Employees SET Department_ID = NULL WHERE Department_ID = ?"
    );
    $stmt->bind_param("i", $departmentId);
    $stmt->execute();

    // Now delete the department
    $stmt = $conn->prepare(
        "DELETE FROM Departments WHERE Department_ID = ?"
    );
    $stmt->bind_param("i", $departmentId);
    $stmt->execute();
}

header("Location: index.php");
exit;
?>