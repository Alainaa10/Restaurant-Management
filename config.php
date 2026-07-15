<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {

    // Local WAMP
    $conn = mysqli_connect("localhost", "root", "", "intern_db");

} else {

    // InfinityFree
    $conn = mysqli_connect(
        "sql104.infinityfree.com",
        "if0_42364505",
        "IJqaQoLjnoI",
        "if0_42364505_intern_db"
    );

}

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>