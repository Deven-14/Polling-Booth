<?php

    require_once "dbh.inc.php";
    require_once "functions.inc.php";

    if(isset($_POST["submit"]))
    {
        $username = $_POST["name"];
        $pwd = $_POST["pwd"];
        loginUser($conn, $username, $pwd);
    }
    else // if someone sneakily accessed this page via the url
    {
        header("location: ../login.php");
        exit();
    }