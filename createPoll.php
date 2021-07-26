<?php
include_once "header.php";

if (!isset($_SESSION["userid"])) {
    header("location: signup.php?error=usernotloggedin");
    exit();
}
?>
<div>
    <!-- <?php
            if (isset($_GET["poll"])) {
                echo "<p>Poll successfully created!</p>";
                echo "<a href=vote.php?id=" . $_GET['poll'] . ">Go to poll</a>";
                echo "<p>Click on the link below to create another poll</p>";
                echo "<a href=createPoll.php>Click here!</a>";
                exit();
            }
            ?> -->
    <section class="form">
        <h1 class="title2">Create a Poll</h1>
        <form id="createPoll" class="contact-form row" action="includes/createPoll.inc.php" method="post">
            <div class="form-field col-lg-6">
                <input placeholder="Question" id="question" name="question" class="input-text js-input" type="text" required>
                <label class="label" for="question">Question</label>
            </div>
            <div class="form-field col-lg-6 ">
                <input placeholder="Question Description" id="description" name="desc" class="input-text js-input" type="text">
                <label class="label" for="description">Question Description </label>
            </div>
            <div class="form-field col-lg-6 ">
                <label for="start" style="color: white;">Start Date </label>
                <input id="start" name="start" class="input-text js-input" type="date">
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
                    <li><input type="text" oninput="validate()" class="input-text js-input" name="options[]" placeholder="Choice 1" required></li>
                    <li><input type="text" oninput="validate()" class="input-text js-input" name="options[]" placeholder="Choice 2" required></li>
                </ul>
            </div>
            <script>
                function validate() {
                    var options = document.getElementById("options").getElementsByTagName("li");
                    var optionNames = new Set();
                    
                    for (var i=0; i<options.length; i++) {
                        var option = options[i].getElementsByTagName('input')[0].value;
                        if (optionNames.has(option)) {
                            document.getElementById("submitbtn").disabled = true;
                            alert("You can't give same choice names!");
                            return;
                        }
                        document.getElementById("submitbtn").disabled = false;
                        optionNames.add(option);
                    }
                }
            </script>
            <div class="form-field col-lg-6">
                <label class="custom-control-label" for="category" style="color: #66fcf1; font-size: 20px;">Choose a category:&emsp;</label>
                <select style="background-color: #1f2833; color: #ffffff" name="category" id="type">  
                    <option style="background-color: #1f2833; color: #ffffff" value="School">School</option>
                    <option style="background-color: #1f2833; color: #ffffff" value="Work">Work</option>
                    <option style="background-color: #1f2833; color: #ffffff" value="Sports">Sports</option>
                    <option style="background-color: #1f2833; color: #ffffff" value="Anime">Anime</option>
                    <option style="background-color: #1f2833; color: #ffffff" value="Games">Games</option>
                    <option style="background-color: #1f2833; color: #ffffff" value="TV Shows">TV Shows</option>
                    <option style="background-color: #1f2833; color: #ffffff" value="Others">Others</option>
                </select>
            </div>
            
            <div class="form-field col-lg-6">
            </div>
            
            <div class="form-field col-lg-6">
                <input class="submit-btn" type="button" value="Add more fields" onclick="addField()">
            </div>
            <div class="form-field col-lg-6">
                <input class="submit-btn" type="button" value="Remove a field" onclick="removeField()">
            </div>

            <div class="custom-control custom-checkbox mb-3 ml-3">
                <input type="checkbox" class="custom-control-input" name="private" value="Y" id="poll-type">
                <label class="custom-control-label" for="poll-type" style="color: #66fcf1; font-size: 20px;">Private Poll</label>

            </div>
            <div class="form-field col-lg-12">
                <input id="submitbtn" class="submit-btn" type="submit" value="Post" name="submit">
            </div>
        </form>
    </section>
</div>
</body>

</html>