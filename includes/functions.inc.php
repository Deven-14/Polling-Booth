 <?php

    function emptyInputSignup($uid, $email, $pwd, $pwdrepeat)
    {
        return (empty($uid) || empty($email) || empty($pwd) || empty($pwdrepeat)) ? true : false;
    }

    function invalidUid($uid)
    {
        return (!preg_match("/^[a-zA-Z0-9]*$/", $uid)) ? true : false;
    }

    function invalidEmail($email)
    {
        return (!filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
    }

    function matchPassword($pwd, $pwdrepeat)
    {
        return ($pwd !== $pwdrepeat) ? true : false;
    }

    function uidExists($conn, $uid, $email)
    {
        // placeholders to avoid sql injection
        $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
        //initialize prepared statement
        $stmt = mysqli_stmt_init($conn); 
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }
        // bind parameters to prepared statement
        mysqli_stmt_bind_param($stmt, "ss", $uid, $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return ($row = mysqli_fetch_assoc($result)) ? $row : false;
    }

    function createUser($conn, $uid, $email, $pwd)
    {
        // placeholders to avoid sql injection
        $sql = "INSERT INTO users (usersUid,usersEmail,usersPwd) VALUES (?, ?, ?);";
        //initialize prepared statement
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
        //default hashing algorithm
        $hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
        // bind parameters to prepared statement
        mysqli_stmt_bind_param($stmt, "sss", $uid, $email, $hashedpwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../login.php?error=none");
        exit();
    }

    function loginUser($conn, $username, $pwd)
    {
        $uidExists = uidExists($conn, $username, $username);
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
            $_SESSION["userid"] = $uidExists["id"];
            $_SESSION["useruid"] = $uidExists["usersUid"];
            header("location: ../index.php");
            exit();
        }
    }

    function isLoggedIn($session)
    {
        return isset($session["userid"]) ? true : false;
    }

    function fetchPoll($conn, $id)
    {
        $sql = "SELECT * FROM polls WHERE id = ?;"; 
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
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

    function createPoll($conn, $question, $start, $end, $user, $desc, $private)
    {
        $sql = "INSERT INTO polls (pollsQues, pollsDesc, pollsStart, pollsEnd, usersId, pollsPrivate) VALUES (?, ?, ?, ?, ?, ?);"; //to avoid sql injection
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
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
        $sql = "INSERT INTO choices (choicesName, pollsId) VALUES (?, ?);"; 
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("location: ../createPoll.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ss", $option, $pollId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    function fetchUsersPolls($conn, $user)
    {
        $sql = "SELECT * FROM polls WHERE usersId = $user;";
        $result = mysqli_query($conn, $sql);
        $rowsNum = mysqli_num_rows($result);
        if ($rowsNum > 0)
        {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;
        }
        return false;        
    }

    function fetchPublicPolls($conn)
    {
        $sql = "SELECT * FROM polls WHERE (DATE(NOW()) BETWEEN pollsStart AND pollsEnd) AND pollsPrivate = 'N';";
        $result = mysqli_query($conn, $sql);
        $rowsNum = mysqli_num_rows($result);
        if ($rowsNum > 0)
        {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;
        }
        return false; 
    }

    function fetchChoices($conn, $id)
    {
        $sql = "SELECT * FROM choices WHERE pollsId = $id;"; 
        $result = mysqli_query($conn, $sql);
        $rowsNum = mysqli_num_rows($result);
        if ($rowsNum > 0)
        {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;
        }
        return false;
    }

    function pollsAnswered($conn, $user)
    {
        $sql = "SELECT polls.id, polls.pollsQues FROM polls JOIN answers ON answers.pollsId = polls.id WHERE answers.usersId = $user;";
        $result = mysqli_query($conn, $sql);
        $rowsNum = mysqli_num_rows($result);
        if ($rowsNum > 0)
        {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $rows;
        }
        return false; 
    }

    function pollAnswered($conn, $user, $poll)
    {
        $sql = "SELECT * FROM answers WHERE usersId = $user AND pollsId = $poll;"; //to avoid sql injection
        $result = mysqli_query($conn, $sql);
        $rowsNum = mysqli_num_rows($result);
        return ($rowsNum > 0) ? true : false;
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
        if (!mysqli_stmt_prepare($stmt, $sql))
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

    function pollExpired($poll)
    {
        return (date("y-m-d") > $poll["pollsEnd"]) ? true : false;
    }

    function deletePoll($conn, $pollId)
    {
        $sql = "DELETE FROM polls WHERE id = $pollId;";
        if (!mysqli_query($conn, $sql))
        {
            header("location: ../profile.php?error=failedtodelete");
            exit();
        }
    }

    function deleteChoices($conn, $pollId)
    {
        $sql = "DELETE FROM choices WHERE pollsId = $pollId;";
        if (!mysqli_query($conn, $sql))
        {
            header("location: ../profile.php?error=failedtodeletechoice");
            exit();
        }
    }

    function editDescField($conn, $pollId, $newDesc)
    {
        $sql = "UPDATE polls SET pollsDesc = ? WHERE id = $pollId;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("location: ../profile.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $newDesc);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }


