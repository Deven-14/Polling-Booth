<?php
include_once "header.php";
require_once "includes/dbh.inc.php";
require_once "includes/functions.inc.php";

if (!isLoggedIn($_SESSION)) {
    header("location: signup.php?error=usernotloggedin");
    exit();
}

if (!isset($_GET["id"])) {
    header("location: polls.php/error=errorloadingpoll");
    exit();
}

$id = (int)$_GET["id"];
$poll = fetchPoll($conn, $id);

if (!$poll) {
    header("location: polls.php?error=polldoesntexist");
    exit();
}

$choices = fetchChoices($conn, $id);

?>
<div>
    <?php
    echo '<div class="poll-center" style="color:#66fcf1;">';
    if (pollAnswered($conn, $_SESSION["userid"], $_GET["id"]) === true && pollExpired($poll) === true) {
        echo "<h2>" . $poll["pollsQues"] . "</h2>";
        if ($poll["pollsDesc"]) {
            echo "<p>" . $poll["pollsDesc"] . "</p><br>";
        }
        echo "<h3 style='color:white;'>Poll answered - </h3>";
        $rows = number_of_choices($conn, $_GET["id"]);
        $sum = array_sum(array_column($rows, 'choice_count'));
        $selectedChoiceIds = array_column($rows, 'choicesId');
        foreach ($choices as $choice) {
            if (!in_array($choice["id"], $selectedChoiceIds)) {
                echo "<div class='choice poll-option'>";
                echo "<label>" . $choice["choicesName"] . " - 0%</label>";
                echo "<progress max='100' value='0'></progress></div>";
            } else {
                foreach ($rows as $row) {
                    if ($row['choicesId'] == $choice["id"]) {
                        echo "<div class='choice poll-option'>";
                        echo "<label>" . $row["choicesName"] . " - " . round($row["choice_count"] / $sum, 3) * 100 . "%</label>";
                        echo "<progress max='100' value='" . round($row["choice_count"] / $sum, 3) * 100 . "'></progress></div>";
                        break;
                    }
                }
            }
        }
        exit();
    }
    echo '</div>';
    ?>
    <div class="poll-center" style="color:#66fcf1;">
        <form action="includes/vote.inc.php" method="POST">
            <?php
            echo "<h2>" . $poll["pollsQues"] . "</h2>";
            if ($poll["pollsDesc"]) {
                echo "<p>" . $poll["pollsDesc"] . "</p><br>";
            }
            ?>
            <div>
                <?php
                if (!empty($choices)) {
                    foreach ($choices as $index => $choice) {
                        echo "<div class='choice poll-option'><input type='radio' name='choice' value=" . $choice["id"] . " id=" . $index . ">";
                        echo "<label for=" . $index . ">" . $choice["choicesName"] . "</label></div>";
                    }
                    echo '<button class="submit-btn-center" type="submit" name="submit">Submit</button></br>';
                    echo '<input type="hidden" name="poll" value=' . $id . '>';
                } else {
                    echo "<p>Sorry no choices available!</p>";
                }
                ?>
            </div>
        </form>
    </div>
</div>
<?php
if (isset($_GET["error"])) {
    $error = $_GET["error"];
    if ($error == "none") {
        echo "<div class='error-block'><p>Poll created successfully!</p></div>";
    } else if ($error == "stmtfailed") {
        echo "<div class='error-block'><p>Oops! Something went wrong</p></div>";
    } else if ($error == "descUpdated") {
        echo "<div class='error-block'><p>Description updated!</p></div>";
    }
}
include_once "footer.php";
?>