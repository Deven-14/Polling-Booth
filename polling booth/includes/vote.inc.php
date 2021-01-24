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
    if (pollAnswered($conn, $_SESSION["userid"], $poll = $_POST["poll"]) == true)
    {
        header("location: ../vote.php?id=".$poll);
        exit();
    }
    else
    {
        $user = $_SESSION["userid"];
        $poll = $_POST["poll"];
        $choice = $_POST["choice"];
        vote($conn, $user, $poll, $choice);
    }  
