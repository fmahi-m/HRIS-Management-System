<?php
include '../../config/auth_check.php';
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employeeId = (int) $_POST['employee_id'];
    $leaveType = $_POST['leave_type'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $status = $_POST['status'];

    $maxIdResult = mysqli_query($conn, "SELECT IFNULL(MAX(Leave_ID), 0) + 1 AS next_id FROM leave_management");
    $nextId = mysqli_fetch_assoc($maxIdResult)['next_id'];

    $stmt = $conn->prepare("INSERT INTO leave_management (Leave_ID, Employee_ID, Leave_Type, Start_Date, End_Date, Status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $nextId, $employeeId, $leaveType, $startDate, $endDate, $status);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

$employees = mysqli_query($conn, "SELECT Employee_ID, Name FROM employees ORDER BY Name");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Leave - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.