<?php
session_start();

include "authRoleCheck.php";
include "config.php";

if(!hasRole('waiter')){
    die("Access Denied");
}

$id=$_GET['id'];

$result=mysqli_query($conn,"
SELECT orders.*,menu.item_name
FROM orders
JOIN menu
ON orders.menu_id=menu.id
WHERE orders.id=$id
");

$order=mysqli_fetch_assoc($result);

if(isset($_POST['save'])){

    $qty=$_POST['quantity'];

    if($qty<1){
        $qty=1;
    }

    mysqli_query($conn,"
    UPDATE orders
    SET quantity='$qty'
    WHERE id=$id
    ");

    header("Location: order_list.php");
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Order</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<?php include "header.php"; ?>
<?php include "navbar.php"; ?>

<div class="container mt-4">

<div class="card">

<div class="card-body">

<h3>Edit Order</h3>

<form method="post">

<div class="mb-3">

<label>Table Number</label>

<input
type="text"
class="form-control"
value="<?= $order['table_number']; ?>"
readonly>

</div>

<div class="mb-3">

<label>Menu Item</label>

<input
type="text"
class="form-control"
value="<?= $order['item_name']; ?>"
readonly>

</div>

<div class="mb-3">

<label>Quantity</label>

<input
type="number"
name="quantity"
class="form-control"
value="<?= $order['quantity']; ?>"
min="1">

</div>

<button class="btn btn-success" name="save">
Save Changes
</button>

<a href="order_list.php" class="btn btn-secondary">
Cancel
</a>

</form>

</div>

</div>

</div>

</body>

</html>