<?php

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(isset($_POST["submit"]))
    {
        extract($_POST, EXTR_SKIP);

        //case taken care of by the html required field
        /*if (emptyInputSignup($uid, $email, $pwd, $pwdrepeat) !== false)
        {
            header("location: ../signup.php?error=emptyinput");
            exit();
        }*/

        if (invalidUid($uname) !== false) {
            header("location: ../signup.php?error=invaliduid");
            exit();
        }

        if (invalidEmail($email) !== false) {
            header("location: ../signup.php?error=invalidemail");
            exit();
        }

        if (matchPassword($pwd, $pwdrepeat) !== false) {
            header("location: ../signup.php?error=passwordsdontmatch");
            exit();
        }
        
        if (uidExists($conn, $email) !== false) {
            header("location: ../signup.php?error=uidexists");
            exit();
        }
        // if you got to this point there is no error
        createUser($conn, $email, $uname, $pwd);
    }
    else
    {
        header("location: ../signup.php");
        exit();
    }