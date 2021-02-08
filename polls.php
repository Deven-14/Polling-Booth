<?php
    include_once "header.php";
    require_once "includes/dbh.inc.php";
    require_once "includes/functions.inc.php";
    $polls = fetchPublicPolls($conn);
?>
        <h1 class="text-center mb-5" style="color: white; font-size:60px;">Polls</h1>

        <div class="polls container">

            <div class="row">
                <?php
                    if(!empty($polls))
                    {
                        foreach($polls as $poll)
                        {
                            echo "<div class='poll-container col-6 col-sm-4'><a href=vote.php?id=" . $poll["id"] . ">" . $poll["pollsQues"] . "</a>";
                            if ($poll["pollsDesc"])
                            {
                                echo "<p>".$poll["pollsDesc"]."</p>";
                            }
                            echo "</div>";
                        }
                    }
                    else
                    {
                        echo "<h3 style='color:grey;'>&nbsp&nbsp--Sorry no polls available!--</h3>";
                    }
                ?>
            </div>
            
        </div>
    </body>
</html>