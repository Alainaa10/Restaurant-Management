<?php

session_start();

include "authRoleCheck.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!(hasRole('admin') || hasRole('Manager') || hasRole('Chef') || hasRole('waiter') || hasRole('cashier'))){
    echo "Access Denied";
    exit();
}

include "config.php";

?>

<?php

include "config.php";
include "header.php";

$id=$_GET['id'];

$result=mysqli_query($conn,"
SELECT orders.*,
       menu.item_name
FROM orders
JOIN menu
ON orders.menu_id=menu.id
WHERE orders.id=$id
");

$order=mysqli_fetch_assoc($result);

?>

<h2>Order Details</h2>

<p><b>Customer :</b> <?= $order['customer_name']; ?></p>

<p><b>Menu Item :</b> <?= $order['item_name']; ?></p>

<p><b>Quantity :</b> <?= $order['quantity']; ?></p>

<p><b>Status :</b> <?= $order['status']; ?></p>

<?php include "footer.php"; ?>