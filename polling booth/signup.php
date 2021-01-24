<?php
    include_once "header.php";
?>
        <div class="signup" style="margin-top:100px;">
            <h2>Sign up!</h2>
            <form action="includes/signup.inc.php" method="post">
                <input type="text" name="uid" placeholder="Username" required><br>
                <input type="text" name="email" placeholder="Email" required><br>
                <input type="password" name="pwd" placeholder="Password" required><br>
                <input type="password" name="pwdrepeat" placeholder="Type password again" required><br>
                <button type="submit" name="submit">Sign Up</button>
            </form>
            <?php
                if (isset($_GET["error"]))
                {
                    $error = $_GET["error"];
                    if($error == "usernotloggedin")
                    {
                        echo "<p>Sign up or Login!</p>";
                    }
                    if($error == "invaliduid")
                    {
                        echo "<p>Enter a valid username</p>";
                    }
                    else if($error == "invalidemail")
                    {
                        echo "<p>Enter a valid email id</p>";
                    }
                    else if($error == "passwordsdontmatch")
                    {
                        echo "<p>Passwords dont match!</p>";
                    }
                    else if($error == "uidexists")
                    {
                        echo "<p>User id already exists</p><br><a href='login.php'>Login here</a>";
                    }
                    else if($error == "stmtfailed")
                    {
                        echo "<p>Oops! Something went wrong</p>";
                    }
                }
            ?>
        </div>
    </body>
</html>