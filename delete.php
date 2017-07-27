<?php
include "base.php";

try {
    if (empty($_SESSION['loggedIn'])) {
        http_response_code(403);
    } else {
        /* Delete user */
        $delete = mysqli_real_query($con, "DELETE FROM `users` WHERE `witEmail` = '" . mysqli_real_escape_string($con, $_SESSION['witEmail']) . "'");

        if (!$delete || mysqli_affected_rows($con) == 0) {
            http_response_code(500);
        } else {
            /* Delete profile picture */
            unlink($_SESSION['imageUrl']);

            /* Destroy session data */
            $_SESSION = array();
            session_destroy();

            http_response_code(200);
        }
    }
} catch (Exception $e) {
    http_response_code(500);
}
