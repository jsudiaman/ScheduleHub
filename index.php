<?php include "base.php" ?>
<!DOCTYPE html>
<html>
<head>
    <title>ScheduleHub</title>
    <link rel="stylesheet" type="text/css" href="css/tacit.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/jquery-3.2.1.js" type="text/javascript"></script>
    <script type="text/javascript">
        function onLoad() {
            // Ensure match between password and password verification
            $("#signUpForm").submit(function (event) {
                if ($("#pw1").val() !== $("#pw2").val()) {
                    event.preventDefault();
                    alert("Passwords don't match.");
                }
            });

            // When group changes, change the options for department
            $("#group").change(function () {
                // Enable the select, as it is initially disabled
                var deptSelect = $("#department");
                deptSelect.prop("disabled", false);

                // Add options
                switch ($(this).val()) {
                    case "Students":
                        deptSelect.html("<option>Computer Science</option><option>Computer Networking</option><option>Biomedical Science</option>");
                        break;
                    case "Faculty":
                        deptSelect.html("<option>Computer Science & Networking</option><option>Biomedical Engineering</option><option>Social Science</option>");
                        break;
                    case "Advisors":
                        deptSelect.html("<option>Financial Aid</option><option>Billing</option><option>Health and Wellness</option>");
                        break;
                }
            });
        }

        $(document).ready(onLoad);
    </script>
    <?php include "favicon.php" ?>
</head>

<body>
<section>
    <?php
    include "header.php";
    if (!empty($_SESSION['loggedIn'])) {
        ?>
        <article>
            <!-- The user has logged in successfully, so we show them the homepage. -->
            <h2 class="header">Welcome to ScheduleHub, <?= htmlspecialchars($_SESSION['name']) ?>!</h2>
            <h3 class="header">You have successfully logged in to the site.</h3>

            <table border="10" cellspacing="0" cellpadding="5" width="95%" align="center">
                <tr>
                    <td>
                        <a href="images/wentworth.jpg">
                            <img class="img-circle" src="images/wentworth.jpg" alt="logo" width="150" height="100">
                        </a>
                    </td>
                    <td><h2>See photos and information of teachers, students and advisors</h2></td>
                </tr>

                <tr>
                    <td>
                        <a href="images/magdy.JPG">
                            <img class="img-circle" src="images/magdy.JPG" alt="logo" width="150" height="100">
                        </a>
                    </td>
                    <td><h2>Visualize schedules of individuals with no hassle</h2></td>
                </tr>

                <tr>
                    <td>
                        <a href="images/meeting.jpg">
                            <img class="img-circle" src="images/meeting.jpg" alt="logo" width="150" height="100">
                        </a>
                    </td>
                    <td><h2>Find availability of individuals and make appointments</h2></td>
                </tr>
            </table>
        </article>
        <?php
    } elseif (isset($_POST['witEmail']) && isset($_POST['password'])) {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $witEmail = mysqli_real_escape_string($con, $_POST['witEmail']);
        $gmail = mysqli_real_escape_string($con, $_POST['gmail']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $group = mysqli_real_escape_string($con, $_POST['group']);
        $department = mysqli_real_escape_string($con, $_POST['department']);

        echo "<article>";

        /* Server-side validation */
        if (empty($name) || empty($witEmail) || empty($gmail) || empty($password) || empty($group) || empty($department)) {
            $errMsg = "Please fill out all required fields.";
        } else if (!filter_var($witEmail, FILTER_VALIDATE_EMAIL)) {
            $errMsg = htmlspecialchars($witEmail) . " is not a valid email. Please go back and try again.";
        } else if (!filter_var($gmail, FILTER_VALIDATE_EMAIL)) {
            $errMsg = htmlspecialchars($gmail) . " is not a valid email. Please go back and try again.";
        }

        /* Validate unique constraint */
        if (!isset($errMsg)) {
            $userSelect = mysqli_query($con, "SELECT * "
                . "FROM users "
                . "WHERE witEmail = '{$witEmail}'");
            if (mysqli_num_rows($userSelect) == 1) {
                $errMsg = "Sorry, that WIT email is taken. Please go back and try again.";
            }
        }

        /* Upload image */
        if (!isset($errMsg) && !empty($_FILES["fileToUpload"]["tmp_name"])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $target_file = $target_dir . uniqid() . ".${imageFileType}";

            /* Check if image file is a actual image or fake image */
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check === false) {
                    $errMsg = "File is not an image.";
                    $uploadOk = 0;
                }
            }

            /* Check if file already exists */
            if (file_exists($target_file)) {
                $errMsg = "Sorry, file already exists.";
                $uploadOk = 0;
            }

            /* Check file size */
            $tenMegabytes = 10 * 1000 * 1000;
            if ($_FILES["fileToUpload"]["size"] > $tenMegabytes) {
                $errMsg = "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            /* Allow certain file formats */
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $errMsg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            /* Check if $uploadOk is set to 0 by an error */
            if ($uploadOk != 0) {
                if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $errMsg = "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            $target_file = null;
        }

        /* Create account or show error */
        if (!isset($errMsg)) {
            $userInsert = mysqli_real_query($con, "INSERT INTO `users` (`name`, `witEmail`, `gmail`, `password`, `group`, `department`, `imageUrl`) "
                . "VALUES ('${name}', '${witEmail}', '${gmail}', '${password}', '${group}', '${department}', '" . mysqli_real_escape_string($con, $target_file) . "')");
            if ($userInsert) {
                echo "<h1>Success</h1>";
                echo "<p>Your account was successfully created. Please <a href=\"login.php\">click here to login</a>.</p>";
            } else {
                echo "<h1>Error</h1>";
                echo "<p>Sorry, your registration failed. Please go back and try again.</p>";
            }
        } else {
            echo "<h1>Error</h1>";
            echo "<p>${errMsg}</p>";
        }

        echo "</article>";
    } else {
        ?>

        <article class="signup">
            <h2>Sign Up</h2>
            <form id="signUpForm" action="index.php" method="POST" enctype="multipart/form-data">
                <p>Already a member? <a href="login.php">Sign in</a></p>

                <input type="text" placeholder="Name" name="name" required><br>
                <input type="text" placeholder="WIT Email" name="witEmail" required><br>
                <input type="text" placeholder="Google Email" name="gmail" required><br>
                <input type="password" placeholder="Password" name="password" id="pw1" required><br>
                <input type="password" placeholder="Re-Enter Password" name="password-verify" id="pw2" required><br>
                <select title="Group" id="group" name="group" required>
                    <option value="" disabled selected>Group...</option>
                    <option>Students</option>
                    <option>Faculty</option>
                    <option>Advisors</option>
                </select><br>
                <select title="Department" id="department" name="department" required disabled>
                    <option value="" disabled selected>Department...</option>
                </select><br>
                <label for="fileToUpload">Profile Picture:</label><br>
                <input type="file" name="fileToUpload" id="fileToUpload"><br>

                <input type="submit" value="Create Account">
            </form>
        </article>

        <?php
    }
    include "footer.php"
    ?>
</section>
</body>
</html>
	