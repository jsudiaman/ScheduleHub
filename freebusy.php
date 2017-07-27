<?php
include "base.php";
include "vendor/autoload.php";

/**
 * Echoes "busy" if the Google user $_GET['gmail'] is busy sometime between $_GET['fTime'] and $_GET['fTime'] on
 * $_GET['date'].
 *
 * Echoes "free" otherwise.
 */

$format = "m/d/Y h:ia";
$timeMin = $_GET['date'] . ' ' . $_GET['fTime'];
$timeMax = $_GET['date'] . ' ' . $_GET['tTime'];

try {
    /* Authentication */
    $client = new Google_Client();
    $client->setApplicationName(GOOGLE_APPLICATION_NAME);
    $client->setDeveloperKey(GOOGLE_CALENDAR_API_KEY);
    $calendar = new Google_Service_Calendar($client);

    /* Submit request */
    $email = $_GET['gmail'];
    $freebusy_req = new Google_Service_Calendar_FreeBusyRequest();
    $freebusy_req->setTimeMin(date_format(date_create_from_format($format, $timeMin), DATE_ATOM));
    $freebusy_req->setTimeMax(date_format(date_create_from_format($format, $timeMax), DATE_ATOM));
    $item = new Google_Service_Calendar_FreeBusyRequestItem();
    $item->setId($email);
    $freebusy_req->setItems(array($item));
    $query = $calendar->freebusy->query($freebusy_req);

    /* Handle response */
    $response_calendar = $query->getCalendars();
    $busy_obj = $response_calendar[$email]->getBusy();
    if (count($busy_obj) > 0) {
        echo "busy";
    } else {
        echo "free";
    }
} catch (Google_Service_Exception $e) {
    /* If exception happens, just ignore and echo "free" */
    echo "free";
}
