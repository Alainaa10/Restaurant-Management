<?php

session_start();

include "authRoleCheck.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(!(hasRole('admin') || hasRole('Manager'))){
    echo "Access Denied";
    exit();
}

include "config.php";

?>

<?php

include "config.php";

$id=$_GET['id'];

mysqli_query($conn,"DELETE FROM menu WHERE id=$id");

header("Location: menu_list.php");

exit();

?>