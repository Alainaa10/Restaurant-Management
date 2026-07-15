<?php

session_start();
include 'authRoleCheck.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!hasRole('admin')){
    echo "Access denied!";
    exit();
}
include 'header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <div class="card">
    <style>

        body{
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 40px;
            text-align: center;
        }

        h2{
            color: #2c3e50;
        }

        p{
            color: #555;
            font-size: 18px;
        }

        a{
            display: inline-block;
            width: 200px;
            padding: 12px;
            margin: 10px;
            color: white;
            background-color: #3498db;
            border-radius: 5px;
            font-weight: bold;
        }

        a:hover{
            background-color: #2980b9;
        }

    </style>

</head>
<body>

<h2>Admin Panel</h2>

<p>Welcome Admin</p>

<a href="user_list.php">Restaurant Staff</a>

<br><br>

<a href="add_role.php">Manage Role</a>

<br><br>

<a href="dashboard.php">Dashboard</a>

<br><br>

<a href="logout.php">Logout</a>

</body>
</html>