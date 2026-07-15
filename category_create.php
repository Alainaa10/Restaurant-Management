


<?php
session_start();
include "authRoleCheck.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!(hasRole('admin') || hasRole('manager'))) {
    echo "Access Denied";
    exit();
}

include "config.php";

if(isset($_POST['submit'])){

$name=$_POST['category_name'];

mysqli_query($conn,"
INSERT INTO category(category_name)
VALUES('$name')
");

header("Location: category_list.php");
exit();

}

include "header.php";
// include "navbar.php";
?>

<div class="container mt-4">

<h2>Add Category</h2>

<form method="post">

<div class="mb-3">

<label>Category Name</label>

<input
type="text"
name="category_name"
class="form-control"
required>

</div>

<input
type="submit"
name="submit"
value="Add Category"
class="btn btn-success">

</form>

</div>

<?php include "footer.php"; ?>