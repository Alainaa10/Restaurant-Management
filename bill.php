<?php

include "config.php";

$id=$_GET['id'];

$result=mysqli_query($conn,"
SELECT orders.*,
menu.item_name,
menu.price
FROM orders
JOIN menu
ON orders.menu_id=menu.id
WHERE orders.id=$id
");

$order=mysqli_fetch_assoc($result);

$total=$order['price']*$order['quantity'];

include "header.php";

?>

<h2>Restaurant Bill</h2>

<table border="1" cellpadding="10">

<tr>

<td>Order ID</td>

<td><?= $order['id']; ?></td>

</tr>

<tr>

<td>Table No</td>

<td><?= $order['table_number']; ?></td>

</tr>

<tr>

<td>Item</td>

<td><?= $order['item_name']; ?></td>

</tr>

<tr>

<td>Price</td>

<td>₹<?= $order['price']; ?></td>

</tr>

<tr>

<td>Quantity</td>

<td><?= $order['quantity']; ?></td>

</tr>

<tr>

<td>Total</td>

<td><b>₹<?= $total; ?></b></td>

</tr>

<tr>

<td>Status</td>

<td><?= $order['status']; ?></td>

</tr>

<tr>

<td>Payment</td>

<td><?= $order['payment_status']; ?></td>

</tr>

</table>

<br>

<button onclick="window.print()">Print Bill</button>

<?php include "footer.php"; ?>