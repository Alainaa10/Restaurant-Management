<?php
session_start();

include "authRoleCheck.php";
include "config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!(hasRole('admin') || hasRole('manager') || hasRole('chef') || hasRole('waiter') || hasRole('cashier'))){
    echo "Access Denied";
    exit();
}


$search = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}
$result = mysqli_query($conn,"
SELECT
orders.id,
orders.table_number,
menu.item_name,
menu.price,
orders.quantity,
orders.status,
orders.payment_status,
orders.created_at
FROM orders
JOIN menu
ON orders.menu_id = menu.id
WHERE
orders.table_number LIKE '%$search%'
OR menu.item_name LIKE '%$search%'
ORDER BY orders.id DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Order Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">

</head>

<body>

<?php include "header.php"; ?>
<?php include "navbar.php"; ?>

<div class="container mt-4">

<div class="card shadow">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>🍽️ Order Management</h2>

<?php if(hasRole('waiter') || hasRole('manager') || hasRole('admin')){ ?>

<a href="order_create.php" class="btn btn-success">
+ Create Order
</a>

<?php } ?>

</div>

<form method="GET" class="mb-3">

<div class="input-group">

<span class="input-group-text bg-white">
🔍
</span>

<input
type="text"
name="search"
class="form-control"
placeholder="Search by Table Number or Menu Item"
value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">

<button class="btn btn-primary px-4">
Search
</button>

<a href="order_list.php" class="btn btn-outline-secondary">Reset</a>

</div>

</form>
<div class="table-responsive">

<table class="table table-bordered table-striped table-hover align-middle">

<thead class="table-dark">

<tr>

<th>ID</th>
<th>Table</th>
<th>Menu Item</th>
<th>Price</th>
<th>Qty</th>
<th>Total</th>
<th>Order Time</th>
<th>Status</th>
<th>Payment</th>
<th width="330">Action</th>

</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)){ ?>


<tr>

<td><?= $row['id']; ?></td>

<td><?= $row['table_number']; ?></td>

<td><?= $row['item_name']; ?></td>

<td>₹<?= number_format($row['price'],2); ?></td>

<td><?= $row['quantity']; ?></td>

<td>₹<?= number_format($row['price'] * $row['quantity'],2); ?></td>
<td><?= date("d-m-Y h:i A", strtotime($row['created_at'])); ?></td>

<td>

<?php

if($row['status']=="Pending"){
    echo "<span class='badge bg-warning text-dark'>Pending</span>";
}
elseif($row['status']=="Preparing"){
    echo "<span class='badge bg-info'>Preparing</span>";
}
elseif($row['status']=="Prepared"){
    echo "<span class='badge bg-primary'>Prepared</span>";
}
elseif($row['status']=="Served"){
    echo "<span class='badge bg-success'>Served</span>";
}
elseif($row['status']=="Order Closed"){
    echo "<span class='badge bg-dark'>Order Closed</span>";
}
else{
    echo $row['status'];   // Temporary debugging
}

?>

</td>

<td>

<?php

if($row['payment_status']=="Paid"){
    echo "<span class='badge bg-success'>Paid</span>";
}
else{
    echo "<span class='badge bg-danger'>Unpaid</span>";
}

?>

</td>

<td>

<a href="order_view.php?id=<?= $row['id']; ?>" class="btn btn-secondary btn-sm">
View
</a>

<?php if(hasRole('waiter') && $row['payment_status']=="Unpaid"){ ?>

<a href="order_edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
Edit
</a>

<?php } ?>

<?php if(hasRole('chef')){ ?>

<a href="order_update.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
Update
</a>

<?php } ?>

<?php if(hasRole('waiter') && $row['status']=="Prepared"){ ?>

<a href="order_update.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">
Serve
</a>

<?php } ?>

<?php if(hasRole('cashier') && $row['status']=="Served" && $row['payment_status']=="Unpaid"){ ?>

<a href="order_update.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">
Mark Paid
</a>

<?php } ?>

<?php if((hasRole('cashier') || hasRole('manager')) && $row['status']=="Served" && $row['payment_status']=="Paid"){ ?>

<a href="close_order.php?id=<?= $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Close this order?')">
Order Closed
</a>

<?php } ?>

<?php if(hasRole('admin') || hasRole('manager') || hasRole('cashier')){ ?>

<?php if($row['payment_status']=="Paid"){ ?>

<a href="bill.php?id=<?= $row['id']; ?>" class="btn btn-dark btn-sm">
Bill
</a>

<?php } ?>

<a href="order_update.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
Edit
</a>

<?php } ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>