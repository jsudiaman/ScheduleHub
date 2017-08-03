<?php
include "base.php";

if (!empty($_GET['gmail'])) {
    $email = $_GET['gmail'];
} elseif (!empty($_SESSION['gmail'])) {
    $email = $_SESSION['gmail'];
}

if (!empty($_GET['name'])) {
    $heading = "Calendar for " . $_GET['name'];
} elseif (!empty($_SESSION['name'])) {
    $heading = "Calendar for " . $_SESSION['name'];
} else {
    $heading = "Calendar";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $heading ?></title>

    <link rel="stylesheet" type="text/css" href="css/tacit.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css">
    <link rel="stylesheet" type="text/css" href="css/kalendae.css">

    <?php include "favicon.php" ?>

    <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="js/jquery.timepicker.min.js" type="text/javascript"></script>
    <script src="js/kalendae.standalone.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        /** Send invitation according to #scheduleForm. */
        function sendInvitation() {
            $.ajax({
                type: "GET",
                url: "schedule.php",
                data: $("#scheduleForm").serialize(),
                success: function (data) {
                    $("#status").html(data);
                }
            });
        }

        $(document).ready(function () {
            // Show wait.gif when AJAX request is initiated
            $(document).ajaxStart(function () {
                $("#status").html("<img src='images/wait.gif' width='64' height='64'>");
            });

            // Submit scheduleForm exclusively through AJAX
            $("#scheduleForm").submit(function (event) {
                event.preventDefault();
                $.ajax({
                    type: "GET",
                    url: "freebusy.php",
                    data: $("#scheduleForm").serialize(),
                    success: function (data) {
                        if (data === "busy") {
                            if (confirm("The individual will be busy during this time. Do you wish to continue?")) {
                                sendInvitation();
                            } else {
                                $("#status").empty();
                            }
                        } else {
                            sendInvitation();
                        }
                    }
                });
            });
        });
    </script>
</head>

<body>
<section>
    <?php
    include "header.php";
    if (isset($email)) {
        ?>
        <article>
            <h2><?= $heading ?></h2>

            <iframe src="https://calendar.google.com/calendar/embed?src=<?= htmlspecialchars($email) ?>&mode=WEEK"
                    style="border: 0; margin-bottom: 1em" width="800" height="600" frameborder="0"
                    scrolling="no"></iframe>

            <?php if (!empty($_SESSION['loggedIn']) && $email != $_SESSION['gmail']) { ?>
            <input id="scheduleAppointment" type="Submit" value="Schedule Appointment" name="schedule">

                <!-- Form-->
                <form id="scheduleForm" hidden>
                    <table id="scheduleTable">
                        <tr>
                            <td><label for="date">Date:</label></td>
                            <td><input type="text" id="date" name="date" class="auto-kal"
                                       data-kal="direction: 'today-future'" required></td>
                        </tr>
                        <tr>
                            <td><label for="fTime">From:</label></td>
                            <td><input type="text" id="fTime" name="fTime" class="timepicker" required></td>
                        </tr>
                        <tr>
                            <td><label for="tTime">To:</label></td>
                            <td><input type="text" id="tTime" name="tTime" class="timepicker" required></td>
                        </tr>
                        <tr>
                            <td><label for="reason">Reason:</label></td>
                            <td><input type="text" id="reason" placeholder="Reason" name="reason"></td>
                        </tr>
                    </table>
                    <input type="Submit" value="Make Appointment">

                    <!-- Carry over existing GET params in form submission -->
                    <input type="hidden" name="gmail" value="<?= htmlspecialchars($email) ?>">
                    <input type="hidden" name="witEmail" value="<?= htmlspecialchars($_GET['witEmail']) ?>">
                    <input type="hidden" name="name" value="<?= htmlspecialchars($_GET['name']) ?>">
                </form>
                <script type="text/javascript">
                    $('#scheduleAppointment').click(function (event) {
                        event.preventDefault();
                        $('#scheduleForm').show();
                        location.href = "#scheduleForm";
                    });

                    $('.timepicker').timepicker();
                </script>

                <!-- Status Indicator -->
                <p id="status"></p>
            <?php
            } else if (empty($_SESSION['loggedIn'])) { ?>
                <h3>Please <a href='index.php'>sign up</a> or <a href='login.php'>log in</a> to schedule an appointment.</h3>
            <?php } else { ?>
                <h3>This is your calendar. <a href='https://github.com/sudiamanj/leopardweb-connector'>Import from LeopardWeb</a></h3>
            <?php } ?>
        </article>
    <?php } else { ?>
        <meta http-equiv="refresh" content="0;login.php">
    <?php } ?>
    <?php include "footer.php" ?>
</section>
</body>

</html>
