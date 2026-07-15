
<?php
session_start();
include "config.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">
<?php
// include 'header.php';
?>

<div class="card">
<h2>User Login</h2>

 <?php if(isset($_SESSION['error'])) { ?>
 <div class="alert alert-danger alert-dismissible fade show">

                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>

                <!-- <button class="btn-close" data-bs-dismiss="alert"></button> -->

            </div>
<?php } ?>

<form action="login_process.php" method="POST">

    Email:
    <input type="email" name="email" required><br><br>

    Password:
    <input type="password" name="password" required><br><br>

    <input type="submit" name="submit" value="Login">

</form>
<?php include 'footer.php'; ?>
</body>
</html>