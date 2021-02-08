<?php
    include_once "header.php";

    if (!isset($_SESSION["userid"]))
    {
        header("location: signup.php?error=usernotloggedin");
        exit();
    }
?>
        <div>
            <?php
            if (isset($_GET["poll"]))
            {
                echo "<p>Poll successfully created!</p>";
                echo "<a href=vote.php?id=".$_GET['poll'].">Go to poll</a>";
                echo "<p>Click on the link below to create another poll</p>";
                echo "<a href=createPoll.php>Click here!</a>";
                exit();
            }
            ?>
            <section class="form">
                <h1 class="title2">Create a Poll</h1>
                <form class="contact-form row" action="includes/createPoll.inc.php" method="post">
                    <div class="form-field col-lg-6">
                        <input id="question" name="question" class="input-text js-input" type="text" required>
                        <label class="label" for="question">Question</label>
                    </div>
                    <div class="form-field col-lg-6 ">
                        <input id="desc" name="desc" class="input-text js-input" type="text" required>
                        <label class="label" for="desc">Question Description </label>
                    </div>
                    <div class="form-field col-lg-6 ">
                        <label for="start" style="color: white;">Start Date </label>
                        <input id="start" name="start" class="input-text js-input" type="date" >
                    </div>
                    <div class="form-field col-lg-6 ">
                        <label for="end" style="color: white;">End Date </label>
                        <input id="end" name="end" class="input-text js-input" type="date">
                    </div>
                    <script>
                        defaultDateToday("start");
                        setMinDateToday("start");
                        defaultDateTomorrow("end");
                        setMinDateToday("end");
                    </script>
                    <div class="form-field col-lg-12 ">
                        <ul id="options" style="list-style-type:none; margin-left: -30px">
                            <li><input type="text" class="input-text js-input" name="options[]" placeholder="Category 1" required></li>
                            <li><input type="text" class="input-text js-input" name="options[]" placeholder="Category 2" required></li>
                        </ul>
                    </div>
                    <div class="form-field col-lg-6">
                        <input class="submit-btn" type="button" value="Add more fields" onclick="addField()">
                    </div>
                    <div class="form-field col-lg-6">
                        <input class="submit-btn" type="button" value="Remove a field" onclick="removeField()">
                    </div>
                    
                    <div class="custom-control custom-checkbox mb-3 ml-3">
                        <input type="checkbox" class="custom-control-input" name="private" value="Y" id="poll-type">
                        <label class="custom-control-label" for="poll-type" style="color: white;">Private Poll</label>
                    </div>
                    <div class="form-field col-lg-12">
                        <input class="submit-btn" type="submit" value="Post" name="submit">
                    </div>
                </form>
            </section>

            <!--<form action="includes/createPoll.inc.php" method="post">
                <label for="question">Question </label>
                <input type="text" name="question" placeholder="Enter the question" id="question" required><br>
                <label for="desc">Question Description </label>
                <input type="text" name="desc" placeholder="Question desription" id="desc"><br>
                <label for="start">Start Date </label>
                <input type="date" id="start" name="start"><br>
                <label for="end">End Date </label>
                <input type="date" id="end" name="end"><br>
                
                <ul id="options">
                    <li><input type="text" name="options[]" placeholder="Category 1" required></li>
                    <li><input type="text" name="options[]" placeholder="Category 2" required></li>
                </ul>
                <input type="button" value="Add more fields" onclick="addField()">
                <input type="button" value="Remove a field" onclick="removeField()"><br>
                <label for="poll-type">Private poll?</label>
                <input type="checkbox" name="private" value="Y" id="poll-type"><br>
                <button type="submit" name="submit" value="submit">Post</button>
            </form>-->
        </div>
    </body>
</html>