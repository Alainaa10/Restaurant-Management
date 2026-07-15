<?php

include "config.php";
include 'header.php';
if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        die("Invalid Email Format");
    }

    $check = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if(mysqli_num_rows($result) > 0){
        die("Email already exists");
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users(name,email,password)
            VALUES('$name','$email','$hashed_password')";

    if(mysqli_query($conn,$sql)){
        echo "Registration Successful";
    }
    else{
        echo "Error: " . mysqli_error($conn);
    }
}
?>
