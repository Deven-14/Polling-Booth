<?php
    include_once "header.php";
?>
        <div class="login" style="margin-top:100px;">
            <h2>Login!</h2>
            <form action="includes/login.inc.php" method="post">
                <input type="text" name="name" placeholder="Username/Email" required><br>
                <input type="password" name="pwd" placeholder="Password" required><br>
                <button type="submit" name="submit">Login</button>
            </form>
            <?php
                if (isset($_GET["error"]))
                {
                    $error = $_GET["error"];
                    if($error == "wronglogin")
                    {
                        echo "<p>Incorrect login</p>";
                    }
                    if($error == "passwordwrong")
                    {
                        echo "<p>Wrong password!</p>";
                    }
                    else if($error == "stmtfailed")
                    {
                        echo "<p>Oops! Something went wrong</p>Login</a>";
                    }
                    else if($error == "none")
                    {
                        echo "<p>Successful Sign up!</p>";
                    }
                }
            ?>
        </div>
    </body>
</html>