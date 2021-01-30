<?php
    include_once "header.php";
    require_once "includes/dbh.inc.php";
    require_once "includes/functions.inc.php";

    if (!isset($_SESSION["userid"]))
    {
        header("location: signup.php?error=usernotloggedin");
        exit();
    }
    $user = $_SESSION["userid"];
    $polls = fetchUsersPolls($conn, $user);
    $AnsweredPolls = pollsAnswered($conn, $user);
?>
        <div>
            <p>Hi user <?php echo $_SESSION["useruid"]; ?>!<p>
            <p>Your polls:</p>
            <?php
                if(!empty($polls))
                {
                    foreach($polls as $poll)
                    {
                        echo "<div class='poll-preview'><a href=vote.php?id=" . $poll["id"] . ">" . $poll["pollsQues"] . "</a>";
                        //echo "<button><a href='editPoll.php?poll=".$poll["id"]."'>Edit</a></button>";
                        echo "<button><a href='includes/deletePoll.inc.php?poll=".$poll["id"]."'>Delete</a></button></div>";
                    }
                }
                else
                {
                    echo "<p>You have no polls</p>";
                }
            ?>
            <p>Polls you have answered:</p>
            <?php
                if(!empty($AnsweredPolls))
                {
                    foreach($AnsweredPolls as $AnsweredPoll)
                    {
                        echo "<div class='poll-preview'><a href=vote.php?id=" . $AnsweredPoll["id"] . ">" . $AnsweredPoll["pollsQues"] . "</a></div>";
                    }
                }
                else
                {
                    echo "<p>Sorry no polls available!</p>";
                }
            ?>
        </div>
    </body>
</html>