<?php
include_once "header.php";
require_once "includes/dbh.inc.php";
require_once "includes/functions.inc.php";

if (!isLoggedIn($_SESSION)) {
    header("location: signup.php?error=usernotloggedin");
    exit();
}

$user = $_SESSION["userid"];
$polls = fetchUsersPolls($conn, $user);
$AnsweredPolls = pollsAnswered($conn, $user);
?>
<div class="polls conatiner">
    <div class="row">
        <h2>Hi user <?php echo $_SESSION["useruid"]; ?>!</h2>
        <h2>Your polls:</h2>
        <?php
        if (!empty($polls)) {
            foreach ($polls as $poll) {
                echo "<div class='poll-container col-6 col-sm-4'><a href=vote.php?id=" . $poll["id"] . ">" . $poll["pollsQues"] . "</a>";
                if ($poll["pollsDesc"]) {
                    echo "<p>" . $poll["pollsDesc"] . "</p>";
                }
                echo "<button><a href='editPoll.php?poll=" . $poll["id"] . "'>Edit</a></button>";
                echo "<button><a href='includes/deletePoll.inc.php?poll=" . $poll["id"] . "'>Delete</a></button></div>";
            }
        } else {
            echo "<h3 style='color:grey;'>&nbsp&nbsp--You have no polls!--</h3>";
        }
        ?>
    </div>
    <div class="row">
        <h2>Polls you have answered:</h2>
        <?php
        if (!empty($AnsweredPolls)) {
            foreach ($AnsweredPolls as $AnsweredPoll) {
                echo "<div class='poll-container col-6 col-sm-4'><a href=vote.php?id=" . $AnsweredPoll["id"] . ">" . $AnsweredPoll["pollsQues"] . "</a></div>";
            }
        } else {
            echo "<p>Sorry no polls available!</p>";
        }
        ?>
    </div>
</div>
<?php
include_once "footer.php";
?>
</body>
</html>