<?php
    include_once "header.php";
?>
        <div style="margin-top:100px;">
            <?php
                if (isset($_SESSION["userid"]))
                {
                    echo "<p>Hello there " . $_SESSION["useruid"] . "!</p>";
                }
            ?>
            <ul>
                <li><a href="polls.php">Public polls</a></li>
                <li><a href="createPoll.php">Create a poll</a></li>
            </ul>
            <?php
                if (isset($_GET["error"]))
                {
                    $error = $_GET["error"];
                    if($error == "stmtfailed")
                    {
                        echo "<p>Uh oh! Something went wrong</p>Login</a>";
                    }
                }
            ?>
        </div>
    </body>
</html>