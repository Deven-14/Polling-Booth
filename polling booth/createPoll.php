<?php
    include_once "header.php";

    if (!isset($_SESSION["userid"]))
    {
        header("location: signup.php?error=usernotloggedin");
        exit();
    }
?>
        <div style="margin-top:100px;">
            <form action="includes/createPoll.inc.php" method="post">
                <label for="question">Question </label>
                <input type="text" name="question" placeholder="Enter the question" id="question" required><br>
                <label for="desc">Question Description </label>
                <input type="text" name="desc" placeholder="Question desription" id="desc"><br>
                <label for="start">Start Date </label>
                <input type="date" id="start" name="start"><br>
                <label for="end">End Date </label>
                <input type="date" id="end" name="end"><br>
                <script>
                    defaultDateToday("start");
                    defaultDateTomorrow("end");
                </script>
                <ul id="options">
                    <li><input type="text" name="options[]" placeholder="Category 1" required></li>
                    <li><input type="text" name="options[]" placeholder="Category 2" required></li>
                </ul>
                <input type="button" value="Add more fields" onclick="addField()">
                <input type="button" value="Remove a field" onclick="removeField()"><br>
                <button type="submit" name="submit" value="submit">Post</button>
            </form>
        </div>
    </body>
</html>