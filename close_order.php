<?php

session_start();

include "authRoleCheck.php";
include "config.php";

if(!(hasRole('cashier') || hasRole('manager'))){
    die("Access Denied");
}

$id = $_GET['id'];

$result = mysqli_query($conn,"
UPDATE orders
SET status='Order Closed'
WHERE id='$id'
");

if(!$result){
    die(mysqli_error($conn));
}

header("Location: order_list.php");
exit();

