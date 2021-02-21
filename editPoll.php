<?php
include_once "header.php";
require_once "includes/functions.inc.php";
require_once "includes/dbh.inc.php";

if (!isset($_SESSION["userid"])) {
    header("location: signup.php?error=usernotloggedin");
    exit();
}
$poll_id = $_GET["poll"];
$poll = fetchPoll($conn, $poll_id);
if ($_SESSION["userid"] != $poll["usersId"]) {
    header("location: profile.php?error=wrongaccess");
    exit();
}
$choices = fetchChoices($conn, $poll_id);
?>
<section class="form">
    <h1 class="title2">Edit Poll</h1>
    <form class="contact-form row" action="<?php echo 'includes/editPoll.inc.php?id=' . $poll_id ?>" method="post">
        <div class="form-field col-lg-12">
            <h5 title="Cannot Edit" style="color: #66fcf1">Question</h5>
            <p class="input-text"><?php echo $poll["pollsQues"]; ?> </p>
        </div>
        <div class="form-field col-lg-12">
            <label style="color: #66fcf1" for="description">
                <h5>Edit Question Description</h5>
            </label>
            <input placeholder="Question Description" id="description" name="newDesc" class="input-text js-input" type="text" value="<?php echo $poll["pollsDesc"]; ?>">

        </div>
        <h5 title="Cannot Edit" style="color: #66fcf1; position: relative; top: 30px">Choices</h5>
        <ul id="options">
            <?php
            foreach ($choices as $choice) { ?>
                <div class="form-field col-lg-12 ">
                    <ul id="options" style="list-style-type:none; margin-left: -30px">
                        <?php echo "<li class='input-text'>" . $choice["choicesName"] . "</li>"; ?>
                    </ul>
                </div>
            <?php
            }
            ?>
        </ul>
        <div class="form-field col-lg-12">
            <button class="submit-btn" type="submit" name="submit" value="submit">Edit</button>
        </div>
    </form>
</section>
</body>

</html>