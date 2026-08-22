<?php
include '../../config/auth_check.php';
include '../../config/db.php';

if (isset($_GET['id'])) {
    $departmentId = (int) $_GET['id'];

    $stmt = $conn->prepare(
        "DELETE FROM departments WHERE Department_ID = ?"
    );
    $stmt->bind_param("i", $departmentId);
    $stmt->execute();
}

header("Location: index.php");
exit;
?>