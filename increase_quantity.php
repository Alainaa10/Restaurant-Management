<?php
session_start();

include "authRoleCheck.php";
include "config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// Only Waiter, Manager and Admin can increase quantity
if(!(hasRole('waiter') || hasRole('manager') || hasRole('admin'))){
    die("Access Denied");
}

$id = $_GET['id'];

// Increase quantity only if order is not yet served
mysqli_query($conn,"
UPDATE orders
SET quantity = quantity + 1
WHERE id = $id
AND status != 'Served'
");

header("Location: order_list.php");
exit();
?>