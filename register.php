<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
include 'header.php';
?>

<div class="card">
<h2>User Registration</h2>

<form action="register_process.php" method="POST">

    Name:
    <input type="text" name="name" required><br><br>

    Email:
    <input type="email" name="email" required><br><br>

    Password:
    <input type="password" name="password" required><br><br>

    <input type="submit" name="submit" value="Register">
   
</form>

</body>
</html>


     
