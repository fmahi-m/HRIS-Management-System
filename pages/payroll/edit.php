<?php
include '../../config/auth_check.php';
include '../../config/db.php';

$id = (int) $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employeeId = (int) $_POST['employee_id'];
    $month = $_POST['month'];
    $basicSalary = (float) $_POST['basic_salary'];
    $deductions = (float) $_POST['deductions'];
    $netSalary = $basicSalary - $deductions;

    $stmt = $conn->prepare("UPDATE payroll SET Employee_ID=?, Month=?, Basic_Salary=?, Deductions=?, Net_Salary=? WHERE Payroll_ID=?");
    $stmt->bind_param("isdddi", $employeeId, $month, $basicSalary, $deductions, $netSalary, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM payroll WHERE Payroll_ID=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$payroll = $stmt->get_result()->fetch_assoc();

$employees = mysqli_query($conn, "SELECT Employee_ID, Name FROM employees ORDER BY Name");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Payroll - HRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"