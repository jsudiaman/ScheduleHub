<?php include "base.php" ?>
<!DOCTYPE html>
<html>
<head>
    <title>Log in ScheduleHub</title>
    <link rel="stylesheet" type="text/css" href="css/tacit.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <?php include "favicon.php" ?>
</head>

<body>
<section>
    <?php
    include "header.php";

    if (isset($_POST['witEmail']) && isset($_POST['password'])) {
        echo "<article>";
        $witEmail = mysqli_real_escape_string($con, $_POST['witEmail']);
        $password = $_POST['password'];

        $userSelect = mysqli_query($con, "SELECT * FROM `users` WHERE `witEmail` = '${witEmail}'");

        if (mysqli_num_rows($userSelect) == 1) {
            // Username is correct, now we must verify the password.
            $row = mysqli_fetch_array($userSelect);

            if (password_verify($password, $row['password'])) {
                // Password is correct:
                $_SESSION['loggedIn'] = 1;
                $_SESSION['name'] = $row['name'];
                $_SESSION['witEmail'] = $witEmail;
                $_SESSION['gmail'] = $row['gmail'];
                $_SESSION['group'] = $row['group'];
                $_SESSION['department'] = $row['department'];
                $_SESSION['imageUrl'] = $row['imageUrl'];

                echo "<h1>Success</h1>";
                echo "<p>We are now redirecting you to the member area.";
                echo "<meta http-equiv='refresh' content='2;index.php' />";
            } else {
                // Password is incorrect:
                echo "<h1>Error</h1>";
                echo "<p>Sorry, username or password is incorrect. Please <a href=\"login.php\">click here to try again</a>.</p>";
            }
        } else {
            // Username is incorrect:
            echo "<h1>Error</h1>";
            echo "<p>Sorry, username or password is incorrect. Please <a href=\"login.php\">click here to try again</a>.</p>";
        }
        echo "</article>";
    } else { ?>
        <article class="login">
            <h2>Log in to ScheduleHub</h2>
            <form action="login.php" method="POST">
                <p>Not a member yet? <a href="index.php">Sign Up</a></p>
                <input type="text" placeholder="WIT Email" name="witEmail" required><br>
                <input type="password" placeholder="Password" name="password" required><br>
                <input type="submit" value="Log In">
            </form>
        </article>
        <?php
    }
    include "footer.php";
    ?>
</section>
</body>

</html>
