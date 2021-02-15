<?php
    include_once "header.php";
    require_once "includes/functions.inc.php";
    require_once "includes/dbh.inc.php";

    if (!isset($_SESSION["userid"]))
    {
        header("location: signup.php?error=usernotloggedin");
        exit();
    }
    $poll_id = $_GET["poll"];
    $poll = fetchPoll($conn, $poll_id);
    if ($_SESSION["userid"] != $poll["usersId"])
    {
        header("location: profile.php?error=wrongaccess");
        exit();
    }
    $choices = fetchChoices($conn, $poll_id);  
?>
        <div>
            <form action="<?php echo 'includes/editPoll.inc.php?id=' . $poll_id?>" method="post">
                <p> <?php echo $poll["pollsQues"];?> </p>
                <input type="text" name="newDesc" value="<?php echo $poll["pollsDesc"];?>" id="desc"><br>
                <button type="submit" name="submit" value="submit">Edit</button>
                <ul id="options">
                <?php
                    foreach($choices as $choice)
                    {
                        echo "<li>" . $choice["choicesName"] . "</li>";
                    }
                ?>
                </ul>
            </form>
        </div>
    </body>
</html>