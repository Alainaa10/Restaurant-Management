<?php

session_start();
include 'authRoleCheck.php';

if (!hasRole('admin')) {
    die("Access Denied");
}

include 'config.php';

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update password only if a new one is entered
    if (!empty($_POST['password'])) {

        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "UPDATE users
                SET name='$name',
                    email='$email',
                    password='$password',
                    role='$role'
                WHERE id=$id";

    } else {

        $sql = "UPDATE users
                SET name='$name',
                    email='$email',
                    role='$role'
                WHERE id=$id";
    }

    mysqli_query($conn, $sql);

    header("Location: user_list.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="card">
<h2>Edit User</h2>

<form method="POST">

    Name:
    <input type="text"
           name="name"
           value="<?php echo $row['name']; ?>">
    <br><br>

    Email:
    <input type="email"
           name="email"
           value="<?php echo $row['email']; ?>">
    <br><br>

    Password:
    <input type="password"
           name="password"
           placeholder="Leave blank to keep current password">
    <br><br>

    Role:
    <select name="role">

        <?php

        $roles = mysqli_query($conn, "SELECT DISTINCT role FROM users");

        while($r = mysqli_fetch_assoc($roles)){
            ?>

        <option value="<?php echo $r['role']; ?>"

            <?php if($r['role'] == $row['role']) echo "selected"; ?>>

            <?php echo ucfirst($r['role']); ?>

        </option>

        <?php
        }
        ?>

    </select>

    <br><br>

    <input type="submit" name="update" value="Update">

</form>

</body>
</html>




