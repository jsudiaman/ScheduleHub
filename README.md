# ScheduleHub
A website for students and faculty to share schedules and arrange meetings.

## Setup
Follow these steps if you wish to run ScheduleHub on your local machine.

### Requirements
- [PHP](http://php.net/)
- [MySQL](https://www.mysql.com/)
- An SMTP server
- Access to the [Google Calendar API](https://developers.google.com/google-apps/calendar/)

### Steps
- Ensure that PHP is configured to allow file uploads. In your `php.ini` file, set `file_uploads = On`.
- Create a new MySQL database. Initialize it using [DDL.sql](/sql/DDL.sql).
- Set the following environment variables:

| Variable                  | Value                                                             |
|---------------------------|-------------------------------------------------------------------|
| `dbhost`                  | Location of your database, e.g. `localhost`                       |
| `dbname`                  | Name of your database                                             |
| `dbuser`                  | Your database username, e.g. `root`                               |
| `dbpass`                  | Your database password                                            |
| `SMTP_HOST`               | Location of your SMTP server                                      |
| `SMTP_NAME`               | Your SMTP server name                                             |
| `SMTP_USERNAME`           | Your SMTP server username                                         |
| `SMTP_PASSWORD`           | Your SMTP server password                                         |
| `TIMEZONE`                | [Timezone](http://php.net/manual/en/timezones.php) of your server |
| `GOOGLE_APPLICATION_NAME` | Google API project name                                           |
| `GOOGLE_CALENDAR_API_KEY` | Google API key                                                    |

- Start the server using the following commands:

```Shell
php composer.phar install
php -S localhost:8000
```

- On your web browser, visit http://localhost:8000/ and you should see ScheduleHub.

## See it in action!
<a href="https://vimeo.com/227415493"><img src="/images/demo.png" alt="Video Demo"></a>
