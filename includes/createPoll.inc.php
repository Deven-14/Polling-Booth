<?php

    session_start();
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(!isset($_POST["submit"]))
    {
        header("location: ../createPoll.php");
        exit();
    }

    if (!isset($_POST["private"]))
    {
        $_POST["private"] = "N";
    }

    extract($_POST, EXTR_SKIP);
    $user = $_SESSION["userid"];
    if(!$desc)
    {
        $desc = NULL;
    }

    $pollId = createPoll($conn, $question, $start, $end, $user, $desc, $private);

    foreach($options as $option)
    {
        createOption($conn, $option, $pollId);
    }

    header("location: ../vote.php?id=".$pollId);

