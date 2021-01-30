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
    if ($_SESSION["userid"] != $poll["pollsAuthor"])
    {
        header("location: profile.php?error=wrongaccess");
        exit();
    }
    $choices = fetchChoices($conn, $poll_id);
?>
        <div>
            <form action="includes/createPoll.inc.php" method="post">
                <label for="question">Question </label>
                <input type="text" name="question" value="<?php echo $poll['pollsQues'];?>"id="question" required><br>
                <label for="desc">Question Description </label>
                <input type="text" name="desc" value="<?php echo $poll['pollsDesc'];?>" id="desc"><br>
                <label for="start">Start Date </label>
                <input type="date" id="start" value="<?php echo $poll['pollsStart'];?>" name="start"><br>
                <label for="end">End Date </label>
                <input type="date" id="end" value="<?php echo $poll['pollsEnd'];?>" name="end"><br>
                <script>
                    setMinDateToday("start");
                    setMinDateToday("end");
                </script>
                <ul id="options">
                <?php
                    foreach($choices as $choice)
                    {
                        echo "<li><input type='text' value='". $choice['choicesName'] ."'required></li>";
                    }
                ?>
                </ul>
                <input type="button" value="Add more fields" onclick="addField()">
                <input type="button" value="Remove a field" onclick="removeField()"><br>
            </form>
        </div>
    </body>
</html>