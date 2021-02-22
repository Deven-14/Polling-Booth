<?php

    session_start();
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $pollId = $_GET["poll"];

    deleteAnswers($conn, $pollId);
    deleteChoices($conn, $pollId);
    deletePoll($conn, $pollId);
    
    header("location: ../profile.php?error=deletionSuccess");
