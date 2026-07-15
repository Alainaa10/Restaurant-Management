<?php
session_start();
include "config.php";
include "authRoleCheck.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!hasRole('admin')) {
    die("Access Denied");
}

$message = "";

if (isset($_POST['submit'])) {

    $role_name = trim($_POST['role_name']);

    if (empty($role_name)) {
        $message = "Role name cannot be empty.";
    } else {

        // Check if role already exists
        $check = mysqli_query($conn, "SELECT * FROM roles WHERE role_name = '$role_name'");

        if (mysqli_num_rows($check) > 0) {
            $message = "Role already exists!";
        } else {

            $stmt = mysqli_prepare($conn, "INSERT INTO roles (role_name) VALUES (?)");
            mysqli_stmt_bind_param($stmt, "s", $role_name);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: add_role.php");
                exit();
            } else {
                $message = "Error adding role.";
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Role</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <h2 class="mb-4">Add New Role</h2>

        <?php if (!empty($message)) { ?>
            <div class="alert alert-warning">
                <?php echo $message; ?>
            </div>
        <?php } ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Role Name</label>
                <input type="text" name="role_name" class="form-control" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">
                Save Role
            </button>

            <a href="add_role.php" class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>

</div>

</body>
</html>