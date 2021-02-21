<?php
include_once "header.php";
require_once "includes/dbh.inc.php";
require_once "includes/functions.inc.php";
$polls = fetchPublicPolls($conn);
?>
<h2 class="text-center mb-5" style="color: white; font-size:50px;">Polls</h2>
<div class="polls container">
    <div class="row">
        <?php
        if (!empty($polls)) {
            foreach ($polls as $poll) {
                echo "<div class='poll-container col-6 col-sm-4'><a href=vote.php?id=" . $poll["id"] . ">" . $poll["pollsQues"] . "</a>";
                if ($poll["pollsDesc"]) {
                    echo "<p class='desc'>" . $poll["pollsDesc"] . "</p>";
                }
                echo "</div>";
            }
        } else {
            echo "<h3 style='color:grey;'>&nbsp&nbsp--Sorry no polls available!--</h3>";
        }
        ?>
    </div>
</div>
<?php
if (isset($_GET["error"])) {
    $error = $_GET["error"];
    if ($error == "erroroccured") {
        echo "<div class='error-block'><p>Uh oh! Some error occured, try again!</p></div>";
    } else if ($error == "errorloadingpoll") {
        echo "<div class='error-block'><p>Oops! Error loading poll</p></div>";
    } else if ($error == "polldoesntexist") {
        echo "<div class='error-block'><p>Poll does not exist</p></div>";
    }
}
include_once "footer.php";
?>
</body>

</html>