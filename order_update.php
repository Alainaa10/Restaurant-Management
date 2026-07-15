<?php
session_start();

include "authRoleCheck.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!(hasRole('admin') || hasRole('manager') || hasRole('chef') || hasRole('waiter') || hasRole('cashier'))){
    echo "Access Denied";
    exit();
}

include "config.php";

$id = $_GET['id'];

$order = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM orders WHERE id=$id"));

if(!$order){
    die("Order not found");
}

if(isset($_POST['submit'])){

    // Chef updates cooking status
    if(hasRole('chef')){
        $status = $_POST['status'];

        mysqli_query($conn,"
        UPDATE orders
        SET status='$status'
        WHERE id=$id
        ");
    }

    // Waiter marks prepared food as served
    elseif(hasRole('waiter')){

        mysqli_query($conn,"
        UPDATE orders
        SET status='Served'
        WHERE id=$id AND status='Prepared'
        ");
    }

    // Cashier marks payment
    elseif(hasRole('cashier')){

        mysqli_query($conn,"
        UPDATE orders
        SET payment_status='Paid'
        WHERE id=$id
        ");
    }

    // Admin/Manager can edit everything
    elseif(hasRole('admin') || hasRole('manager')){

        $status = $_POST['status'];
        $payment = $_POST['payment_status'];

        mysqli_query($conn,"
        UPDATE orders
        SET status='$status',
            payment_status='$payment'
        WHERE id=$id
        ");
    }

    header("Location: order_list.php");
    exit();
}

include "header.php";
?>

<h2>Update Order</h2>

<form method="post">

<?php if(hasRole('chef')){ ?>

Status

<select name="status">

<option value="Pending" <?= $order['status']=="Pending"?"selected":""; ?>>Pending</option>

<option value="Preparing" <?= $order['status']=="Preparing"?"selected":""; ?>>Preparing</option>

<option value="Prepared" <?= $order['status']=="Prepared"?"selected":""; ?>>Prepared</option>

</select>

<br><br>

<input type="submit" name="submit" value="Update Status">

<?php } ?>

<?php if(hasRole('waiter')){ ?>

<p><b>Table:</b> <?= $order['table_number']; ?></p>

<p><b>Status:</b> <?= $order['status']; ?></p>

<?php if($order['status']=="Prepared"){ ?>

<input type="submit" name="submit" value="Mark as Served">

<?php }else{ ?>

<p>Food is not ready yet.</p>

<?php } ?>

<?php } ?>

<?php if(hasRole('cashier')){ ?>

<p><b>Table:</b> <?= $order['table_number']; ?></p>

<p><b>Status:</b> <?= $order['status']; ?></p>

<p><b>Payment:</b> <?= $order['payment_status']; ?></p>

<?php if($order['status']=="Served" && $order['payment_status']=="Unpaid"){ ?>

<input type="submit" name="submit" value="Mark as Paid">

<?php }else{ ?>

<p>Payment cannot be updated yet.</p>

<?php } ?>

<?php } ?>

<?php if(hasRole('admin') || hasRole('manager')){ ?>

Status

<select name="status">

<option value="Pending" <?= $order['status']=="Pending"?"selected":""; ?>>Pending</option>

<option value="Preparing" <?= $order['status']=="Preparing"?"selected":""; ?>>Preparing</option>

<option value="Prepared" <?= $order['status']=="Prepared"?"selected":""; ?>>Prepared</option>

<option value="Served" <?= $order['status']=="Served"?"selected":""; ?>>Served</option>

</select>

<br><br>

Payment

<select name="payment_status">

<option value="Unpaid" <?= $order['payment_status']=="Unpaid"?"selected":""; ?>>Unpaid</option>

<option value="Paid" <?= $order['payment_status']=="Paid"?"selected":""; ?>>Paid</option>

</select>

<br><br>

<input type="submit" name="submit" value="Update">

<?php } ?>

</form>

<?php include "footer.php"; ?>