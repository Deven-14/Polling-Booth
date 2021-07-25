<?php
include_once "header.php";
?>
<div class="content container">
    <div class="row">
        <div class="col-12 col-lg-5"><img id="poll-clipart" src="images/poll-clipart.png"></div>
        <div class="col-12 col-lg-7 direct-poll">
            <h2 id="sub-title">Polling Booth</h2>
            <h5>
                Whatever the scenario or setting, Polling Booth's online polling helps you to get the answers you need.
                Create online polls in seconds and see the results as your audience vote on any web-enabled device.
                It's that simple.
                Use it in your flipped classroom, in your lecture or just to amaze your audience.
            </h5>
            <?php
            if (isset($_SESSION["userid"])) {
                echo "<h6>Hello there " . $_SESSION["username"] . "!</h5>";
            }
            ?>
            <!-- <button class="nice-buttons"><a href="polls.php">Public polls</a></li></button> -->
            <button class="nice-buttons"><a href="categories.php">Public polls</a></li></button>
            <button class="nice-buttons"><a href="createPoll.php">Create a poll</a></button>
        </div>
    </div>
</div>
<?php
if (isset($_GET["error"])) {
    $error = $_GET["error"];
    if ($error == "stmtfailed") {
        echo "<div class='error-block'><p>Uh oh! Something went wrong</p>Login</a></div>";
    }
}
?>
<?php
include_once "footer.php";
?>
</body>

</html>