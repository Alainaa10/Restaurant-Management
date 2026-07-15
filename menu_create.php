<?php

session_start();

include "authRoleCheck.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!(hasRole('admin') || hasRole('Manager'))){
    echo "Access Denied";
    exit();
}

include "config.php";

?>

<?php
include "config.php";

$categories=mysqli_query($conn,"SELECT * FROM category");

if(isset($_POST['submit'])){

$item=$_POST['item_name'];

$category=$_POST['category_id'];

$price=$_POST['price'];

mysqli_query($conn,"
INSERT INTO menu(item_name,category_id,price)
VALUES('$item','$category','$price')
");

header("Location: menu_list.php");

exit();
}
?>

<?php include "header.php"; ?>

<h2>Add Menu Item</h2>

<form method="post">

Item Name

<input type="text" name="item_name" required>

<br><br>

Category

<select name="category_id" required>

<option value="">Select Category</option>

<?php while($cat=mysqli_fetch_assoc($categories)){ ?>

<option value="<?php echo $cat['id']; ?>">

<?php echo $cat['category_name']; ?>

</option>

<?php } ?>

</select>

<br><br>

Price

<input type="number" name="price" required>

<br><br>

<input type="submit" name="submit" value="Add Item">

</form>

<?php include "footer.php"; ?>