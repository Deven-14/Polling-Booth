<?php
include_once "header.php";
?>
<div class="login">
    <h2>Sign up!</h2>
    <hr>
    <form action="includes/signup.inc.php" method="post">
        <input type="text" name="uname" id="uname" placeholder="Username" required><br>
        <input type="text" name="email" id="email" placeholder="Email" required><br>
        <input type="password" name="pwd" id="pwd" placeholder="Password" required><br>
        <input type="password" name="pwdrepeat" id="pwdrepeat" placeholder="Type password again" required><br>
        <button type="submit" name="submit">Sign Up</button>
    </form>
    <a href="login.php">I have an account already!</a>
    <?php
    if (isset($_GET["error"])) {
        $error = $_GET["error"];
        if ($error == "usernotloggedin") {
            echo "<p>Sign up or Login!</p>";
        }
        if ($error == "invaliduid") {
            echo "<p>Enter a valid username</p>";
        } else if ($error == "invalidemail") {
            echo "<p>Enter a valid email-id</p>";
        } else if ($error == "passwordsdontmatch") {
            echo "<p>Passwords don't match!</p>";
        } else if ($error == "uidexists") {
            echo "<p>Account already exists, <a href='login.php'>Login here</a></p>";
        } else if ($error == "stmtfailed") {
            echo "<p>Oops! Something went wrong</p>";
        }
    }
    ?>
</div>
</body>

</html>