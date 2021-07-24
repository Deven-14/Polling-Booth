<?php

    $serverName = "localhost";
    $dBUsername = "root";
    $dBPassword = "";
    $dBName = "pollingbooth";
    $dBPort = 3307;

    $conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName, $dBPort);

    if (!$conn)
    {
        die("Connection failed: " . mysqli_connect_error());
    }
