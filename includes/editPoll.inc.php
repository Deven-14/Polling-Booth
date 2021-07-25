<?php
    session_start();
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(!isset($_POST["submit"]))
    {
        header("location: ../createPoll.php");
        exit();
    }

    $poll = $_GET["id"];
    extract($_POST, EXTR_SKIP);
    editDescField($conn, $poll, $newDesc);
    header("location: ../vote.php?id=".$poll."&error=descUpdated");