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
        <div class="error-block">
        <h2>Hello user <?php echo $_SESSION["useruid"]; ?>!</h2>
        </div>
        <h2>Your polls:</h2>
        <?php
        if (!empty($polls)) {
            foreach ($polls as $poll) {
                echo "<div class='poll-container col-6 col-sm-4'><a href=vote.php?id=" . $poll["id"] . ">" . $poll["pollsQues"] . "</a>";
                $category = ($poll['pollsPrivate'] === 'Y') ? "Private" : "Public";
                echo "<h6 class='category'>". $category . "</h6>";
                if ($poll["pollsDesc"]) {
                    echo "<p class='desc'>" . $poll["pollsDesc"] . "</p>";
                }
                echo "<button class='submit-btn prof-btn'><a href='editPoll.php?poll=" . $poll["id"] . "'>Edit</a></button>";
                echo "<button class='submit-btn prof-btn'><a href='includes/deletePoll.inc.php?poll=" . $poll["id"] . "'>Delete</a></button></div>";
            }
        } else {
            echo "<h4 style='color:grey;'>&nbsp&nbsp--You have no polls!--</h4>";
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
            echo "<h4 style='color:grey;'>&nbsp&nbsp--Sorry no polls available!--</h4>";
        }
        ?>
    </div>
</div>
<?php
if (isset($_GET["error"])) {
    $error = $_GET["error"];
    if ($error == "deletionSuccess") {
        echo "<div class='error-block'><p>Poll deleted successfully!</p></div>";
    }
}
include_once "footer.php";
?>
</body>
</html>