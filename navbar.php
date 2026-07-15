<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg bg-white shadow-sm rounded mb-4">

    <div class="container">

        <div class="ms-auto">

            <?php if(isset($_SESSION['user_id'])){ ?>

                <!-- Dashboard -->
                <a href="dashboard.php" class="btn btn-outline-dark me-2">
                    Dashboard
                </a>

                <!-- Admin -->
                <?php if(hasRole('admin')){ ?>

                    <a href="user_list.php" class="btn btn-outline-primary me-2">
                        Users
                    </a>

                <?php } ?>

                <!-- Admin & Manager -->
                <?php if(hasRole('admin') || hasRole('manager')){ ?>

                    <a href="category_list.php" class="btn btn-outline-success me-2">
                        Categories
                    </a>

                    <a href="menu_list.php" class="btn btn-outline-success me-2">
                        Menu
                    </a>

                <?php } ?>

                <!-- All Restaurant Staff -->
                <?php if(
                    hasRole('admin') ||
                    hasRole('manager') ||
                    hasRole('chef') ||
                    hasRole('waiter') ||
                    hasRole('cashier')
                ){ ?>

                    <a href="order_list.php" class="btn btn-outline-warning me-2">
                        Orders
                    </a>

                <?php } ?>

                <!-- Logout -->
                <a href="logout.php" class="btn btn-danger">
                    Logout
                </a>

            <?php } else { ?>

                <a href="login.php" class="btn btn-success">
                    Login
                </a>

            <?php } ?>

        </div>

    </div>

</nav>