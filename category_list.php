<?php
session_start();

include "authRoleCheck.php";
include "config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!(hasRole('admin') || hasRole('manager'))){
    echo "Access Denied";
    exit();
}

$result = mysqli_query($conn,"SELECT * FROM category ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>

    <title>Category Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>

<body>

<?php include "header.php"; ?>
<?php include "navbar.php"; ?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2>📂 Category Management</h2>

                <a href="category_create.php" class="btn btn-success">
                    + Add Category
                </a>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th width="80">ID</th>
                            <th>Category Name</th>
                            <th width="200">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php while($row=mysqli_fetch_assoc($result)){ ?>

                        <tr>

                            <td><?= $row['id']; ?></td>

                            <td><?= $row['category_name']; ?></td>

                            <td>

                                <a href="category_edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <a href="category_delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Delete this category?');">
                                    Delete
                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>