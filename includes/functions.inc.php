<?php

    function emptyInputSignup($uid, $email, $pwd, $pwdrepeat)
    {
        $result;
        if (empty($uid) || empty($email) || empty($pwd) || empty($pwdrepeat))
        {
            $result = true;
        }
        else
        {
            $result = false;
        }
        return $result;
    }

    function invalidUid($uid)
    {
        $result;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $uid))
        {
            $result = true;
        }
        else
        {
            $result = false;
        }
        return $result;
    }

    function invalidEmail($email)
    {
        $result;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $result = true;
        }
        else
        {
            $result = false;
        }
        return $result;
    }

    function matchPassword($pwd, $pwdrepeat)
    {
        $result;
        if ($pwd !== $pwdrepeat)
        {
            $result = true;
        }
        else
        {
            $result = false;
        }
        return $result;
    }

    function uidExists($conn, $uid, $email)
    {
        $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;"; //to avoid sql injection
        $stmt = mysqli_stmt_init($conn); //initialize prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) //check if prepared statement worked
        {
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ss", $uid, $email);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($resultData))
        {
            return $row;
        }
        else 
        {
            return false;
        }
        mysqli_stmt_close($stmt);
    }

    function createUser($conn, $uid, $email, $pwd)
    {
        $sql = "INSERT INTO users (usersUid,usersEmail,usersPwd) VALUES (?, ?, ?);"; //to avoid sql injection
        $stmt = mysqli_stmt_init($conn); //initialize prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) //check if prepared statement worked
        {
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }
        $hashedpwd = password_hash($pwd, PASSWORD_DEFAULT); //default hashing algorithm
        mysqli_stmt_bind_param($stmt, "sss", $uid, $email, $hashedpwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../login.php?error=none");
        exit();
    }

    function loginUser($conn, $username, $pwd)
    {
        $uidExists = uidExists($conn, $username, $username); //associative array
        if ($uidExists === false)
        {
            header("location: ../login.php?error=wronglogin");
            exit();
        }
        $pwdHashed = $uidExists["usersPwd"];
        $checkPwd = password_verify($pwd, $pwdHashed);
        if ($checkPwd === false)
        {
            header("location: ../login.php?error=passwordwrong");
            exit();
        }
        else if ($checkPwd === true) // login the user into the website
        {
            session_start(); //starting a session
            $_SESSION["userid"] = $uidExists["usersId"];
            $_SESSION["useruid"] = $uidExists["usersUid"];
            header("location: ../index.php");
            exit();
        }
    }

    function fetchPoll($conn, $id)
    {
        $sql = "SELECT * FROM polls WHERE id = ?;"; 
        $stmt = mysqli_stmt_init($conn); //initialize prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) //check if prepared statement worked
        {
            header("location: ../polls.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultData);
        return $row;
    }

    function fetchUsersPolls($conn, $user)
    {
        $sql = "SELECT id, pollsQues FROM polls WHERE pollsAuthor = $user;";
        $stmt = mysqli_stmt_init($conn); //initialize prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) //check if prepared statement worked
        {
            header("location: index.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $rows = mysqli_fetch_all($resultData, MYSQLI_ASSOC);
        return $rows;
    }

    function fetchPublicPolls($conn)
    {
        $sql = "SELECT * FROM polls WHERE (DATE(NOW()) BETWEEN pollsStart AND pollsEnd) AND pollsPrivate = 'N';";
        $stmt = mysqli_stmt_init($conn); //initialize prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) //check if prepared statement worked
        {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $rows = mysqli_fetch_all($resultData, MYSQLI_ASSOC);
        return $rows;
    }

    function fetchChoices($conn, $id)
    {
        $sql = "SELECT * FROM choices WHERE pollsId = ?;"; 
        $stmt = mysqli_stmt_init($conn); //initialize prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) //check if prepared statement worked
        {
            header("location: ../profile.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $rows = mysqli_fetch_all($resultData, MYSQLI_ASSOC);
        return $rows;
    }

    function pollsAnswered($conn, $user)
    {
        $sql = "SELECT polls.id, polls.pollsQues FROM polls JOIN answers ON answers.pollsId = polls.id WHERE answers.usersId = $user;";
        $stmt = mysqli_stmt_init($conn); //initialize prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) //check if prepared statement worked
        {
            header("location: ?error=stmtfailed");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $rows = mysqli_fetch_all($resultData, MYSQLI_ASSOC);
        return $rows;
    }

    function pollAnswered($conn, $user, $poll)
    {
        $sql = "SELECT * FROM answers WHERE usersId = ? AND pollsId = ?;"; //to avoid sql injection
        $stmt = mysqli_stmt_init($conn); //initialize prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) //check if prepared statement worked
        {
            header("location: ../polls.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ss", $user, $poll);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($resultData))
        {
            return true;
        }
        else 
        {
            return false;
        }
        mysqli_stmt_close($stmt);
    }

    function createPoll($conn, $question, $start, $end, $user, $desc, $private)
    {
        $sql = "INSERT INTO polls (pollsQues, pollsDesc, pollsStart, pollsEnd, pollsAuthor, pollsPrivate) VALUES (?, ?, ?, ?, ?, ?);"; //to avoid sql injection
        $stmt = mysqli_stmt_init($conn); //initialize prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) //check if prepared statement worked
        {
            header("location: ../createPoll.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ssssss", $question, $desc, $start, $end, $user, $private);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return mysqli_insert_id($conn);
    }

    function createOption($conn, $option, $pollId)
    {
        $sql = "INSERT INTO choices (choicesName, pollsId) VALUES (?, ?);"; //to avoid sql injection
        $stmt = mysqli_stmt_init($conn); //initialize prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) //check if prepared statement worked
        {
            header("location: ../createPoll.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ss", $option, $pollId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    function vote($conn, $user, $poll, $choice)
    {
        $sql = "INSERT INTO answers (usersId, pollsId, choicesId) 
                        SELECT ?, ?, ? 
                        WHERE EXISTS (SELECT id FROM polls WHERE id = ?)
                        AND EXISTS (SELECT id FROM choices WHERE id = ?)
                        AND NOT EXISTS (SELECT id FROM answers WHERE usersId = ? AND pollsId = ?) 
                        LIMIT 1;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) //check if prepared statement worked
        {
            header("location: ../polls.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "sssssss", $user, $poll, $choice, $poll, $choice, $user, $poll);
        if (!mysqli_stmt_execute($stmt))
        {
            header("location: ../vote.php?id=".$poll."&error=failedtovote");
            exit();
        }
        mysqli_stmt_close($stmt);
        header("location: ../vote.php?id=".$poll);
        exit();
    }

    function number_of_choices($conn, $pollsId)
    {
        $sql = "SELECT choices.choicesName, answers.choicesId, COUNT(*) AS choice_count
                 FROM answers JOIN choices ON answers.choicesId = choices.id 
                 WHERE answers.pollsId = $pollsId GROUP BY answers.choicesId";
        $result = mysqli_query($conn, $sql);
        $rowsNum = mysqli_num_rows($result);
        if ($rowsNum > 0)
        {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;
        }
        return false;
    }

    function isLoggedIn($session)
    {
        return isset($session["userid"]) ? true : false;
    }

    function pollExpired($poll)
    {
        return (date("y-m-d") > $poll["pollsEnd"]) ? true : false;
    }

    function deletePoll($conn, $pollId)
    {
        $sql = "DELETE FROM polls WHERE id = $pollId;"; //to avoid sql injection
        $stmt = mysqli_stmt_init($conn); //initialize prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) //check if prepared statement worked
        {
            header("location: ../profile.php?error=stmtfailed");
            exit();
        }
        if (!mysqli_stmt_execute($stmt))
        {
            header("location: ../profile.php?error=failedtodelete");
            exit();
        }
        mysqli_stmt_close($stmt);
    }

    function deleteChoices($conn, $pollsId)
    {
        $sql = "DELETE FROM choices WHERE pollsId = $pollsId;"; //to avoid sql injection
        $stmt = mysqli_stmt_init($conn); //initialize prepared statement
        if (!mysqli_stmt_prepare($stmt, $sql)) //check if prepared statement worked
        {
            header("location: ../profile.php?error=stmtfailed");
            exit();
        }
        if (!mysqli_stmt_execute($stmt))
        {
            header("location: ../profile.php?error=failedtodeletechoice");
            exit();
        }
        mysqli_stmt_close($stmt);
    }