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
include "header.php";

$result = mysqli_query($conn,"
SELECT menu.id,
       menu.item_name,
       category.category_name,
       menu.price
FROM menu
JOIN category
ON menu.category_id = category.id
");
?>

<h2>Menu Management</h2>

<a href="menu_create.php">+ Add Menu Item</a>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Item Name</th>
    <th>Category</th>
    <th>Price</th>
    <th>Action</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['item_name']; ?></td>

<td><?php echo $row['category_name']; ?></td>

<td><?php echo $row['price']; ?></td>

<td>

<a href="menu_edit.php?id=<?php echo $row['id']; ?>">Edit</a>

<a href="menu_delete.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this item?')">Delete</a>

</td>

</tr>

<?php } ?>

</table>

<?php include "footer.php"; ?>