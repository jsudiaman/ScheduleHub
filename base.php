<?php
session_start();

/* Database information. */
$dbhost = getenv("dbhost");
$dbname = getenv("dbname");
$dbuser = getenv("dbuser");
$dbpass = getenv("dbpass");

/* Connect to database. */
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

/* Check connection. */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

/* SMTP information. */
define("SMTP_HOST", getenv("SMTP_HOST"));
define("SMTP_NAME", getenv("SMTP_NAME"));
define("SMTP_USERNAME", getenv("SMTP_USERNAME"));
define("SMTP_PASSWORD", getenv("SMTP_PASSWORD"));

/* Timezone information. */
date_default_timezone_set(getenv("TIMEZONE"));

/* Google Calendar API information. */
define("GOOGLE_APPLICATION_NAME", getenv("GOOGLE_APPLICATION_NAME"));
define("GOOGLE_CALENDAR_API_KEY", getenv("GOOGLE_CALENDAR_API_KEY"));
