<?php
session_start();

include "authRoleCheck.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!(hasRole('admin') || hasRole('Manager') || hasRole('Chef') || hasRole('User')|| hasRole('waiter'))){
    echo "Access Denied";
    exit();
}

include "config.php";

$menu = mysqli_query($conn,"SELECT * FROM menu");

if(isset($_POST['submit'])){

    $table_number = $_POST['table_number'];
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity'];

    mysqli_query($conn,"
    INSERT INTO orders(table_number,menu_id,quantity,status,payment_status)
    VALUES('$table_number','$menu_id','$quantity','Pending','Unpaid')
    ");

    header("Location: order_list.php");
    exit();
}

include "header.php";
?>

<h2>Create Order</h2>

<form method="post">

Table Number

<input type="number" name="table_number" min="1" required>

<br><br>

Menu Item

<select name="menu_id">

<?php while($m=mysqli_fetch_assoc($menu)){ ?>

<option value="<?= $m['id']; ?>">

<?= $m['item_name']; ?>

</option>

<?php } ?>

</select>

<br><br>

Quantity

<input type="number" name="quantity" min="1" required>

<br><br>

<input type="submit" name="submit" value="Create Order">

</form>

<?php include "footer.php"; ?>