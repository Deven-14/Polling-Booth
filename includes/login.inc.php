<?php

    require_once "dbh.inc.php";
    require_once "functions.inc.php";

    if(isset($_POST["submit"]))
    {
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];
        loginUser($conn, $email, $pwd);
    }
    else // if someone sneakily accessed this page via the url
    {
        header("location: ../login.php");
        exit();
    }