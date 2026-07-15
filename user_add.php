<?php

session_start();
include 'authRoleCheck.php';
include 'header.php';
if (!hasRole('admin')) {
    die("Access Denied");
}

include 'config.php';

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Prepared statement
    $sql = "INSERT INTO users (name, email, password, role)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $password, $role);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: user_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

?>
<div class="card">
<form method="POST">

    Name:
    <input type="text" name="name"><br><br>

    Email:
    <input type="email" name="email"><br><br>

    Password:
    <input type="password" name="password"><br><br>

    Role:
    <select name="role">

    <?php
    // $roles = mysqli_query($conn, "SELECT DISTINCT role FROM users");
    $roles = mysqli_query($conn, "SELECT role_name FROM roles ORDER BY role_name");
    
    // while ($role = mysqli_fetch_assoc($roles)) {
    // ?>
    //     <option value="<?php echo $role['role']; ?>">

    //         <?php echo ucfirst($role['role']); ?>
    //     </option>
    <?php while ($role = mysqli_fetch_assoc($roles)) { ?>
    <option value="<?php echo $role['role_name']; ?>">
        <?php echo ucfirst($role['role_name']); ?>
    </option>
<?php } ?>
    <?php
    
    ?>
    </select>
    <br><br>

    <input type="submit" name="submit" value="Add User">

</form>