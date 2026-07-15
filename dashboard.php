<?php
session_start();

include 'authRoleCheck.php';
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container mt-5">

<div class="card shadow p-4">

<h2 class="mb-3">
Welcome, <?php echo ucfirst($_SESSION['user_name']); ?>
</h2>

<p>

<strong>Role :</strong>

<span class="badge bg-primary">

<?php echo ucfirst($_SESSION['role']); ?>

</span>

</p>

<?php

$totalUsers = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM users"));

$totalCategories = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM category"));

$totalMenu = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM menu"));

$totalOrders = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM orders"));

$pending = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM orders WHERE status='Pending'"));

$preparing = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM orders WHERE status='Preparing'"));

$prepared = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM orders WHERE status='Prepared'"));

$served = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM orders WHERE status='Served'"));

$closed = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM orders WHERE status='Order Closed'"));


$revenue = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(menu.price * orders.quantity) AS total
FROM orders
JOIN menu
ON orders.menu_id = menu.id
WHERE orders.payment_status='Paid'
"));
?>
<div class="row g-4 mb-4">

<div class="col-lg-4 col-md-6">
<div class="card shadow-sm text-center">
<div class="card-body">
<h6>Total Users</h6>
<h2 class="text-primary"><?= $totalUsers['total']; ?></h2>
</div>
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="card shadow-sm text-center">
<div class="card-body">
<h6>Categories</h6>
<h2 class="text-success"><?= $totalCategories['total']; ?></h2>
</div>
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="card shadow-sm text-center">
<div class="card-body">
<h6>Menu Items</h6>
<h2 class="text-info"><?= $totalMenu['total']; ?></h2>
</div>
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="card shadow-sm text-center">
<div class="card-body">
<h6>Total Orders</h6>
<h2 class="text-dark"><?= $totalOrders['total']; ?></h2>
</div>
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="card shadow-sm text-center">
<div class="card-body">

<h6>Total Revenue</h6>

<h2 class="text-success">
₹<?= number_format($revenue['total'] ?? 0, 2); ?>
</h2>

</div>
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="card shadow-sm text-center">
<div class="card-body">
<h6>Pending Orders</h6>
<h2 class="text-warning"><?= $pending['total']; ?></h2>
</div>
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="card shadow-sm text-center">
<div class="card-body">
<h6>Preparing Orders</h6>
<h2 class="text-info"><?= $preparing['total']; ?></h2>
</div>
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="card shadow-sm text-center">
<div class="card-body">
<h6>Prepared Orders</h6>
<h2 class="text-primary"><?= $prepared['total']; ?></h2>
</div>
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="card shadow-sm text-center">
<div class="card-body">
<h6>Served</h6>
<h2 class="text-success"><?= $served['total']; ?></h2>
</div>
</div>
</div>

<div class="col-lg-4 col-md-6">
<div class="card shadow-sm text-center">
<div class="card-body">
<h6>Closed Orders</h6>
<h2 class="text-secondary"><?= $closed['total']; ?></h2>
</div>
</div>
</div>

</div>

<?php if(hasRole('admin')){ ?>

<a href="admin.php" class="btn btn-primary mb-4">
Admin Panel
</a>

<?php

$totalUsers=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users"));

$result=mysqli_query($conn,"
SELECT role,
COUNT(*) total
FROM users
GROUP BY role
");

?>
<div class="card shadow-sm mb-4">

<div class="card-body">

<h4>Total Users</h4>

<h2><?= $totalUsers; ?></h2>

</div>

</div>

<h4 class="mb-3">

Users By Role

</h4>

<div class="table-responsive">

<table class="table table-bordered table-striped table-hover">

<thead class="table-dark">

<tr>

<th>Role</th>

<th>Total Users</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?= ucfirst($row['role']); ?></td>

<td><?= $row['total']; ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<?php } else { ?>

<div class="alert alert-info">

Welcome

<strong>

<?= ucfirst($_SESSION['role']); ?>

</strong>

</div>

<?php } ?>

<a href="logout.php" class="btn btn-danger mt-3">

Logout

</a>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>