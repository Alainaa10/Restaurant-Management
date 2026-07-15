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

$result = mysqli_query($conn, "SELECT * FROM roles ORDER BY id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Role Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Role Management</h2>

            <a href="role_create.php" class="btn btn-success">
                + Add Role
            </a>

        </div>

        <table class="table table-bordered table-hover text-center">

            <thead class="table-dark">

                <tr>
                    <th>ID</th>
                    <th>Role Name</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td><?php echo $row['id']; ?></td>

                    <td><?php echo ucfirst($row['role_name']); ?></td>

                    <td>
                        <a href="delete_role.php?id=<?php echo $row['id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this role?');">
                            Delete
                        </a>
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

        <a href="admin.php" class="btn btn-secondary mt-3">
            Back
        </a>

    </div>

</div>

</body>
</html>