<?php include "base.php" ?>
<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
    <link rel="stylesheet" type="text/css" href="css/tacit.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/jquery-3.2.1.js" type="text/javascript"></script>
    <script type="text/javascript">
        function onLoad() {
            $('#deleteAccount').click(function (event) {
                event.preventDefault();
                if (confirm("Are you sure you want to delete your account?")) {
                    $.ajax({
                        url: "delete.php",
                        success: function () {
                            alert("Account deleted!");
                            location.href = "index.php";
                        },
                        error: function () {
                            alert("Delete failed!");
                        }
                    });
                }
            });
        }

        $(document).ready(onLoad);
    </script>
    <?php include "favicon.php" ?>
</head>

<body>
<section>
    <?php include "header.php" ?>
    <article>
        <?php if (!empty($_SESSION['loggedIn'])) { ?>
            <input id="deleteAccount" type="submit" value="Delete Account">
        <?php } else { ?>
            Please <a href="login.php">login</a> to access your settings.
        <?php } ?>
    </article>
    <?php include "footer.php" ?>
</section>
</body>
</html>
