<?php
session_start();

include "config.php";
include "authRoleCheck.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!hasRole('admin')) {
    die("Access Denied");
}

if (!isset($_GET['id'])) {
    header("Location: add_role.php");
    exit();
}

$id = $_GET['id'];

// Get the role name
$stmt = mysqli_prepare($conn, "SELECT role_name FROM roles WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {

    $roleName = $row['role_name'];

    // Check if any user has this role
    $check = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM users WHERE role = ?");
    mysqli_stmt_bind_param($check, "s", $roleName);
    mysqli_stmt_execute($check);

    $checkResult = mysqli_stmt_get_result($check);
    $count = mysqli_fetch_assoc($checkResult);

    if ($count['total'] > 0) {
        die("Cannot delete this role because it is assigned to one or more users.");
    }

    // Safe to delete
    $delete = mysqli_prepare($conn, "DELETE FROM roles WHERE id = ?");
    mysqli_stmt_bind_param($delete, "i", $id);

    if (mysqli_stmt_execute($delete)) {
        header("Location: add_role.php");
        exit();
    } else {
        echo "Error deleting role.";
    }

} else {
    echo "Role not found.";
}
?>