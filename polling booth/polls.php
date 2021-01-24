<?php
    include_once "header.php";
    require_once "includes/dbh.inc.php";
    require_once "includes/functions.inc.php";
    $polls = fetchAllPolls($conn);
?>
        <div style="margin-top:100px;">
            <ul>
                <?php
                    if(!empty($polls))
                    {
                        foreach($polls as $poll)
                        {
                            echo "<li><a href=vote.php?id=" . $poll["id"] . ">" . $poll["pollsQues"] . "</a></li>";
                        }
                    }
                    else
                    {
                        echo "<p>Sorry no polls available!</p>";
                    }
                ?>
            </ul>
        </div>
    </body>
</html>