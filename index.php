<?php
    include_once "header.php";
?>
        <div class="content">
            <img id="poll-clipart" src="images/poll-clipart1.png">
            <h2 id="sub-title">Some catchy line</h2>
            <h4 id="description">Description... 
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
            when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
            It has survived not only five centuries, but also the leap into electronic typesetting, 
            remaining essentially unchanged. 
            It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            </h4>
            <?php
                if (isset($_SESSION["userid"]))
                {
                    echo "<p>Hello there " . $_SESSION["useruid"] . "!</p>";
                }
            ?>
            <button class="nice-buttons"><a href="polls.php">Public polls</a></li></button>
            <button class="nice-buttons"><a href="createPoll.php">Create a poll</a></button>
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