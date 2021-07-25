<?php

require_once 'encryption.inc.php';

function emptyInputSignup($uid, $email, $pwd, $pwdrepeat) {
    return (empty($uid) || empty($email) || empty($pwd) || empty($pwdrepeat)) ? true : false;
}

function invalidUid($uid)
{
    return (!preg_match("/^[a-zA-Z0-9]+$/", $uid)) ? true : false;
}

function invalidEmail($email)
{
    return (!filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
}

function matchPassword($pwd, $pwdrepeat)
{
    return ($pwd !== $pwdrepeat) ? true : false;
}

function uidExists($conn, $email)
{
    // placeholders to avoid sql injection
    // $sql = "SELECT * FROM users WHERE usersUid = ? OR emailId = ?;";
    $sql = "SELECT * FROM users WHERE emailId = ?;";
    //initialize prepared statement
    $stmt = mysqli_stmt_init($conn); 
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    $encryptedemail = encrypt($email);
    // bind parameters to prepared statement
    mysqli_stmt_bind_param($stmt, "s", $encryptedemail);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return ($row = mysqli_fetch_assoc($result)) ? $row : false;
}

function createUser($conn, $email, $uname, $pwd)
{
    // placeholders to avoid sql injection
    $sql = "INSERT INTO users (emailId, name, passwd) VALUES (?, ?, ?);";
    //initialize prepared statement
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../login.php?error=stmtfailed");
        exit();
    }
    
    $encryptedemail = encrypt($email);
    // default hashing algorithm
    $hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);

    // bind parameters to prepared statement
    mysqli_stmt_bind_param($stmt, "sss", $encryptedemail, $uname, $hashedpwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../login.php?error=none");
    exit();
}

function loginUser($conn, $email, $pwd)
{
    $uidExists = uidExists($conn, $email);
    if ($uidExists === false)
    {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    $pwdHashed = $uidExists["passwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);
    if ($checkPwd === false)
    {
        header("location: ../login.php?error=passwordwrong");
        exit();
    }
    else if ($checkPwd === true) // login the user into the website
    {
        session_start(); //starting a session
        $_SESSION["userid"] = $uidExists["emailId"];
        $_SESSION["username"] = $uidExists["name"];
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
    $sql = "SELECT * FROM polls WHERE pollId = ?;"; 
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

function createPoll($conn, $user, $type, $question, $description, $start, $end, $private)
{
    $sql = "INSERT INTO polls (userId, type, question, description, startDate, endDate, isPrivate) VALUES (?, ?, ?, ?, ?, ?, ?);"; //to avoid sql injection
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../createPoll.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssssss", $user, $type, $question, $description, $start, $end, $private);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return mysqli_insert_id($conn);
}

function createOption($conn, $pollId, $choice)
{
    $sql = "INSERT INTO choices (pollId, choiceName) VALUES (?, ?);"; 
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../createPoll.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $pollId, $choice);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function fetchUsersPolls($conn, $user) {
    $sql = "SELECT * FROM polls WHERE userId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rowsNum = mysqli_num_rows($result);
    if ($rowsNum > 0)
    {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }
    return false;
}

function fetchCategories($conn) {
    $sql = "SELECT * FROM categories;";
    $result = mysqli_query($conn, $sql);
    $rowsNum = mysqli_num_rows($result);
    if ($rowsNum > 0) {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }
    return false;
}

function fetchPublicPolls($conn, $type) {
    $sql = "SELECT * FROM polls WHERE type = ? AND (DATE(NOW()) BETWEEN startDate AND endDate) AND isPrivate = 'N';";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rowsNum = mysqli_num_rows($result);
    if ($rowsNum > 0)
    {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }
    return false;

}

function fetchChoices($conn, $poll) {
    $sql = "SELECT * FROM choices WHERE pollId = ?;"; 
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {      
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $poll);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rowsNum = mysqli_num_rows($result);
    if ($rowsNum > 0)
    {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }
    return false;
}

function pollsAnswered($conn, $user) {
    $sql = "SELECT polls.pollId, polls.question FROM polls JOIN answers ON polls.pollId = answers.pollId WHERE answers.userId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rowsNum = mysqli_num_rows($result);
    if ($rowsNum > 0)
    {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }
    return false;
     
}

function pollAnswered($conn, $user, $poll) {
    //$sql = "SELECT * FROM answers WHERE userId = $user AND pollId = $poll;"; 
    //$result = mysqli_query($conn, $sql);
    //$rowsNum = mysqli_num_rows($result);
    //return ($rowsNum > 0) ? true : false;

    $sql = "SELECT * FROM answers WHERE userId = ? AND pollId = ?;"; 
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $user, $poll);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rowsNum = mysqli_num_rows($result);
    return ($rowsNum > 0) ? true : false;
}

function vote($conn, $user, $poll, $choice) {
    /*$sql = "INSERT INTO answers (userId, pollId, choiceName) VALUES (?, ?, ?) WHERE EXISTS (SELECT pollId FROM polls WHERE pollId = ?) 
    AND EXISTS (SELECT pollId, choiceName FROM choices WHERE pollId = ? AND choiceName = ?) 
    AND NOT EXISTS (SELECT * FROM answers WHERE userId = ? AND pollId = ?); 
    UPDATE choices SET nSelected = nSelected + 1 WHERE pollId = ? AND choiceName = ?;";
    */
    $sql = "INSERT INTO answers (userId, pollId, choiceName) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../vote.php?id=".$poll."&error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $user, $poll, $choice);
    
    if (!mysqli_stmt_execute($stmt)) {
        //echo mysqli_stmt_error($stmt);
        header("location: ../vote.php?id=".$poll."&error=failedtovote");
        exit();
    }
    mysqli_stmt_close($stmt);
    $sql2 = "UPDATE choices SET nSelected = nSelected + 1 WHERE pollId = ? AND choiceName = ?;";
    $stmt2 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt2, $sql2)) {
        header("location: ../vote.php?id=".$poll."&error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt2, "ss", $poll, $choice);
    
    if (!mysqli_stmt_execute($stmt2)) {
        //echo mysqli_stmt_error($stmt);
        header("location: ../vote.php?id=".$poll."&error=failedtoinccount");
        exit();
    }
    mysqli_stmt_close($stmt2);
    header("location: ../vote.php?id=".$poll);
    exit();
}

/*
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
*/

function number_of_choices($conn, $poll)
{
    $sql = "SELECT choicesName, nSelected AS choice_count
             FROM choices WHERE pollId = $poll";
    $result = mysqli_query($conn, $sql);
    $rowsNum = mysqli_num_rows($result);
    if ($rowsNum > 0)
    {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }
    return false;
}


function selectedChoice($conn, $user, $poll)
{
    // $sql = "SELECT choices.choicesName, answers.choicesId
    //         FROM answers JOIN choices ON answers.choicesId = choices.id 
    //        WHERE answers.pollsId = $poll AND answers.usersId = $user";
    $sql = "SELECT choiceName FROM answers WHERE pollId = ? AND userId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $poll, $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rowsNum = mysqli_num_rows($result);
    if ($rowsNum > 0)
    {
        $rows = mysqli_fetch_assoc($result);
        return $rows;
    }
    return false;
}

function pollExpired($poll)
{
    return (date("y-m-d") > $poll["endDate"]) ? true : false;
}

function deletePoll($conn, $poll)
{
    $sql = "DELETE FROM polls WHERE pollId = $poll;";
    if (!mysqli_query($conn, $sql)) {
        header("location: ../profile.php?error=failedtodelete");
        exit();
    }
}

function deleteChoices($conn, $poll)
{
    $sql = "DELETE FROM choices WHERE pollId = $poll;";
    if (!mysqli_query($conn, $sql)) {
        header("location: ../profile.php?error=failedtodeletechoice");
        exit();
    }
}

function deleteAnswers($conn, $poll)
{
    $sql = "DELETE FROM answers WHERE pollId = $poll;";
    if (!mysqli_query($conn, $sql))
    {
        header("location: ../profile.php?error=failedtodeleteanswers");
        exit();
    }
}

function editDescField($conn, $poll, $newDesc)
{
    $sql = "UPDATE polls SET description = ? WHERE pollId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $newDesc, $poll);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

