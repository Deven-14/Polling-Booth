<?php
    include_once "header.php";
?>
        <div class="content container">

            <div class="row">
            
                <div class="col-12 col-lg-5"><img id="poll-clipart" src="images/poll-clipart.png"></div>

                <div class="col-12 col-lg-7 direct-poll">
                    <h2 id="sub-title">Direct Poll</h2>
                    <h3 id="description">
                    Create and conduct polls in a minute. Use it in your flipped classroom, in your lecture or just to amaze your audience.
                    </h3>
                    <?php
                        if (isset($_SESSION["userid"]))
                        {
                            echo "<p>Hello there " . $_SESSION["useruid"] . "!</p>";
                        }

                    ?>
                    <button class="nice-buttons"><a href="polls.php">Public polls</a></li></button>
                    <button class="nice-buttons"><a href="createPoll.php">Create a poll</a></button>
                    <?php
                        if (isset($_GET["error"]))
                        {
                            $error = $_GET["error"];
                            if($error == "stmtfailed")
                            {
                                echo "<p>Uh oh! Something went wrong</p>Login</a>";
                            }
                        }

                    ?>
                </div>
            </div> 
        </div>

        <footer class="footer m-0 p-0">
            <div class="container">
                <div class="row mt-5 pt-5">              
                    <div class="col-4 offset-1 col-sm-2">
                        <h5>Our Events</h5>
                          <ul class="list-unstyled">
                              <li><a  href="wedding.html">Wedding</a></li>
                              <li><a  href="festivals.html">Festivals</a> </li>
                              <li><a  href="corporate.html">Corporate events</a></li>
                              <li><a  href="birthday.html">Birthday</a></li>
                              <li><a  href="social.html">Social Events</a></li>
                          </ul>
                    </div>
                    <div class="col-7 col-sm-5">
                        <h5>Our Address</h5>
                        <address>
                       Near Bull Temple road,
                       Basavangudi
                       Bangalore-19
                       Karnataka,India<br>
                        <i class="fa fa-phone fa-lg"></i> Tel.: 12334556<br>
                        <i class="fa fa-fax fa-lg"></i>Fax: +852 8765 4321<br>
                        <i class="fa fa-envelope fa-lg"></i>Email: <a href="mailto:esperance@events.net">esperance@events.net</a>
                    </address>
                    </div>
                    <div class="col-12 col-sm-4 align-self-center">
                        <div class="text-center">
                            <a class="btn btn-social-icon btn-google" href="http://google.com/+"><i class=" fa fa-google-plus  fa-lg"></i></a>
                            <a class="btn btn-social-icon btn-facebook" href="http://www.facebook.com/profile.php?id="><i class=" fa fa-facebook fa-lg"></i></a>
                            <a class="btn btn-social-icon btn-linkedin" href="http://www.linkedin.com/in/"><i class=" fa fa-linkedin  fa-lg"></i></a>
                            <a class="btn btn-social-icon btn-twitter" href="http://twitter.com/"><i class=" fa fa-twitter  fa-lg"></i></a>
                            <a class="btn btn-social-icon btn-youtube" href="http://youtube.com/"><i class=" fa fa-youtube  fa-lg"></i></a>
                            <a class="btn btn-social-icon btn-envelope" href="mailto:"><i class=" fa fa-envelope  fa-lg"></i></a>
                        </div>
                    </div>
            </div>
            <div class="row justify-content-center">             
                    <div class="col-auto">
                        <p>© Copyright 2020 Polling Booth</p>
                    </div>
            </div>
            </div>
        </footer>

    </body>
</html>