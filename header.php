<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="A website with attractive polls">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="Polling, Voting">
        <title>Polling Booth</title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link type="text/css" href="style.css" rel="stylesheet">
        <script type="text/javascript" src="script.js"></script>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    </head>
    <body">
        <header>     
            <nav>
                <a href="index.php" class="title">Polling Booth</a>
                <div class="nav-bar">
                    <button onclick="menuDropdown()"><i class="fa fa-bars"></i></button>
                    <ul class="nav-menu">
                        <li><a href="index.php" class="nav-links">Home</a></li>
                        <li><a href="#" class="nav-links">About</a></li>
                        <li><a href="#" class="nav-links">Contact</a></li>
                        <?php
                            if (isset($_SESSION["userid"]))
                            {
                                echo '<li><a href="profile.php" class="nav-links">Profile</a></li>';
                                echo '<li><a href="includes/logout.inc.php" class="nav-links">Logout</a></li>';
                            }
                            else
                            {
                                echo '<li><a href="signup.php" class="nav-links">Sign Up</a></li>';
                                echo '<li><a href="login.php" class="nav-links">Login</a></li>';
                            }
                        ?>
                    </ul>
                </div>   
            </nav>
        </header>
