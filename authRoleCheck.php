<?php

function hasRole($role){
    return isset($_SESSION['role']) &&
           strtolower(trim($_SESSION['role'])) == strtolower(trim($role));
}
?>