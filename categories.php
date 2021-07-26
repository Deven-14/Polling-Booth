<?php
include_once "header.php";
require_once "includes/dbh.inc.php";
require_once "includes/functions.inc.php";
$categories = fetchCategories($conn);
?>
<h2 class="text-center mb-5" style="color: white; font-size:50px;">Categories</h2>
<div class="polls container">
    <div class="row">
        <?php
        if (!empty($categories)) {
            foreach ($categories as $category) {
                echo "<div class='poll-container col-6 col-sm-4'><a href=polls.php?type=" .urlencode($category["type"]) . ">" . $category["type"] . "</a>";
                if ($category["description"]) {
                    echo "<p class='desc'>" . $category["description"] . "</p>";
                }
                echo "</div>";
            }
        } else {
            echo "<h3 style='color:grey;'>&nbsp&nbsp--Sorry no categories available!--</h3>";
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