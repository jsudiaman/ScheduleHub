<?php
include "base.php";

$group = $_GET['group'];
$department = $_GET['department'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>List of <?= htmlspecialchars($group) ?></title>
    <link rel="stylesheet" type="text/css" href="css/tacit.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        function onLoad() {
            $(".seeSchedule").click(function (event) {
                event.preventDefault();
                var params = $.param({
                    'gmail': $(this).attr("data-gmail"),
                    'witEmail': $(this).attr("data-witEmail"),
                    'name': $(this).attr("data-name")
                });
                location.href = "calendar.php?" + params;
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
        <h2><?= htmlspecialchars($group) ?> of <?= htmlspecialchars($department) ?></h2>
        <?php
        $query = "SELECT * FROM users "
            . "WHERE `group` = '" . mysqli_real_escape_string($con, $group)
            . "' AND `department` = '" . mysqli_real_escape_string($con, $department) . "' "
            . "ORDER BY `name`";
        if ($result = mysqli_query($con, $query)) {
            if (mysqli_num_rows($result) == 0) {
                echo "No " . htmlspecialchars($group) . " of " . htmlspecialchars($department) . " found.";
            } else {
                /* fetch associative array */
                echo "<table>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td><a href='" . htmlspecialchars($row['imageUrl']) . "'><img src='" . htmlspecialchars($row['imageUrl']) . "' alt='" . htmlspecialchars($row['name']) . "' width='150' height='150'></a></td>";
                    echo "<td><h3>" . htmlspecialchars($row['name']) . "</h3><p>Email: " . htmlspecialchars($row['witEmail']) . "</p></td>";
                    echo "<td><input class='seeSchedule' type='Submit' value='See Schedule' data-gmail='" . htmlspecialchars($row['gmail']) . "' data-witEmail='" . htmlspecialchars($row['witEmail']) . "' data-name='" . htmlspecialchars($row['name']) . "'></td>";
                    echo "</tr>";
                }
                echo "</table>";

                /* free result set */
                mysqli_free_result($result);
            }
        }
        ?>
    </article>
    <?php include "footer.php" ?>
</section>
</body>
</html>
