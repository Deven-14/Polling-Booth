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
    $polls = fetchPolls($conn, $user);
    $AnsweredPolls = pollsAnswered($conn, $user);
?>
        <div style="margin-top:100px;">
            <p>Hi user <?php echo $_SESSION["useruid"]; ?>!<p>
            <p>Your polls:</p>
            <ul>
                <?php
                    if(!empty($polls))
                    {
                        foreach($polls as $poll)
                        {
                            echo "<li><a href=vote.php?id=" . $poll["id"] . ">" . $poll["pollsQues"] . "</a></li>";
                        }
                    }
                    else
                    {
                        echo "<p>You have no polls</p>";
                    }
                ?>
            </ul>
            <p>Polls you have answered:</p>
            <ul>
                <?php
                    if(!empty($AnsweredPolls))
                    {
                        foreach($AnsweredPolls as $AnsweredPoll)
                        {
                            echo "<li><a href=vote.php?id=" . $AnsweredPoll["id"] . ">" . $AnsweredPoll["pollsQues"] . "</a></li>";
                        }
                    }
                    else
                    {
                        echo "<p>Sorry no polls available!</p>";
                    }
                ?>
            </ul>
        </div>
    </body>
</html>