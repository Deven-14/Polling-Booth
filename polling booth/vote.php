<?php
    include_once "header.php";
    require_once "includes/dbh.inc.php";
    require_once "includes/functions.inc.php";

    if (!isset($_SESSION["userid"]))
    {
        header("location: signup.php?error=usernotloggedin");
        exit();
    }

    if (!isset($_GET["id"]))
    {
        header("location: polls.php/error=errorloadingpoll");
        exit();
    }
    $id = (int)$_GET["id"];
    $poll = fetchPoll($conn, $id);        
    if (!$poll)
    {
        header("location: polls.php?error=polldoesntexist");
        exit();
    }
    $choices = fetchChoices($conn, $id);
?>
<div class="poll" style="margin-top:100px;">
    <?php
        if (pollAnswered($conn, $_SESSION["userid"], $_GET["id"]) === true)
        {
            echo "Poll answered";
            exit();
        }
    ?>
    <div class="poll-question">
        <form action="includes/vote.inc.php" method="POST">
            <?php 
                echo "<p>".$poll["pollsQues"]."</p>";
                if($poll["pollsDesc"])
                {
                    echo "<p>".$poll["pollsDesc"]."</p><br>";
                }
            ?>
            <div class="poll-options">
                <?php
                    if(!empty($choices))
                    {
                        foreach($choices as $index=>$choice)
                        {
                            echo "<input type='radio' name='choice' value=" . $choice["id"] . " id=" . $index . ">";
                            echo "<label for=" . $index . ">" . $choice["choicesName"] . "</label>";
                        }
                        echo '<button type="submit" name="submit">Submit</button>';
                        echo '<input type="hidden" name="poll" value=' . $id .'>';
                    }
                    else
                    {
                        echo "<p>Sorry no choices available!</p>";
                    }
                    if (isset($_GET["error"]))
                    {
                        $error = $_GET["error"];
                        if($error == "none")
                        {
                            echo "<p>Vote cast successfully!</p>";
                        }
                        else if($error == "stmtfailed")
                        {
                            echo "<p>Oops! Something went wrong</p>";
                        }
                    }
                ?>
            </div>
        </form>
    </div>
</div>