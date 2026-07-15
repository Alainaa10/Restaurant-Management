

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

$id=$_GET['id'];

$category=mysqli_fetch_assoc(
mysqli_query($conn,"SELECT * FROM category WHERE id=$id")
);

if(isset($_POST['submit'])){

$name=$_POST['category_name'];

mysqli_query($conn,"
UPDATE category
SET category_name='$name'
WHERE id=$id
");

header("Location: category_list.php");
exit();

}

include "header.php";
// include "navbar.php";
?>

<div class="container mt-4">

<h2>Edit Category</h2>

<form method="post">

<div class="mb-3">

<label>Category Name</label>

<input
type="text"
name="category_name"
class="form-control"
value="<?php echo $category['category_name']; ?>"
required>

</div>

<input
type="submit"
name="submit"
value="Update"
class="btn btn-primary">

</form>

</div>

<?php include "footer.php"; ?>