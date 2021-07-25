<?php
    session_start();

    require_once "functions.inc.php";
    require_once "dbh.inc.php";

    if (!isset($_POST["submit"]))
    {
        header("location: ../polls.php?error=erroroccured");
        exit();
        
    }
    if (!isset($_SESSION["userid"]))
    {
        header("location: ../signup.php?error=usernotloggedin");
        exit();
    }

    // print_r($_POST);
    // print_r($_SESSION);
    $user = $_SESSION["userid"];
    $poll = $_POST["poll"];
    $choice = $_POST["choice"];
    // echo $user ." " . $poll . " ".$choice;
    vote($conn, $user, $poll, $choice); 

