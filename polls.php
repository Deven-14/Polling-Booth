<?php
    include_once "header.php";
    require_once "includes/dbh.inc.php";
    require_once "includes/functions.inc.php";
    $polls = fetchPublicPolls($conn);
?>
        <div class="polls">
            <h2>Polls</h2>
            <?php
                if(!empty($polls))
                {
                    foreach($polls as $poll)
                    {
                        echo "<div class='poll-preview'><a href=vote.php?id=" . $poll["id"] . ">" . $poll["pollsQues"] . "</a>";
                        if ($poll["pollsDesc"])
                        {
                            echo "<p>".$poll["pollsDesc"]."</p>";
                        }
                        echo "</div>";
                    }
                }
                else
                {
                    echo "<p>Sorry no polls available!</p>";
                }
            ?>
        </div>
    </body>
</html>