<?php

session_start();
include 'authRoleCheck.php';

if(!hasRole('admin')){
    die("Access Denied");
}


include 'config.php';

$id = $_GET['id'];

$stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);                            // i = integer
mysqli_stmt_execute($stmt);


header("Location:user_list.php");
?>