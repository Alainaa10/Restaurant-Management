<?php
session_start();
include 'authRoleCheck.php';

if (!hasRole('admin')) {
    die("Access Denied");
}

include 'config.php';

$result = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h2>User Management</h2>

            <a href="user_add.php" class="btn btn-success">
                ➕ Add User
            </a>

        </div>

        <?php if(isset($_SESSION['success'])) { ?>

            <div class="alert alert-success alert-dismissible fade show">

                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>

                <button class="btn-close" data-bs-dismiss="alert"></button>

            </div>

        <?php } ?>

        <table class="table table-bordered table-hover">

            <thead class="table-primary">

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['role']; ?></td>

                    <td>
                        <a href="user_edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>

                        <a href="user_delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>