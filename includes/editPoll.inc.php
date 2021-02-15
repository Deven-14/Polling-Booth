<?php
    session_start();
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(!isset($_POST["submit"]))
    {
        header("location: ../createPoll.php");
        exit();
    }

    $pollId = $_GET["id"];
    extract($_POST, EXTR_SKIP);
    editDescField($conn, $pollId, $newDesc);
    header("location: ../vote.php?id=".$pollId."&error=descUpdated");