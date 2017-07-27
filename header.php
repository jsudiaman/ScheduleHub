<header><h1><img src="images/logo.jpg" alt="logo" width="120" height="100">&nbsp;&nbsp;ScheduleHub</h1></header>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li class="dropdown">
            <a href="#">Students</a>
            <div class="dropdown-content">
                <a href="list.php?group=Students&department=Computer%20Science">Computer Science</a>
                <a href="list.php?group=Students&department=Computer%20Networking">Computer Networking</a>
                <a href="list.php?group=Students&department=Biomedical%20Science">Biomedical Science</a>
            </div>
        </li>
        <li class="dropdown">
            <a href="#">Faculty</a>
            <div class="dropdown-content">
                <a href="list.php?group=Faculty&department=Computer%20Science%20%26%20Networking">Computer Science &
                    Networking</a>
                <a href="list.php?group=Faculty&department=Biomedical%20Engineering">Biomedical Engineering</a>
                <a href="list.php?group=Faculty&department=Social%20Science">Social Science</a>
            </div>
        </li>
        <li class="dropdown">
            <a href="#">Advisors</a>
            <div class="dropdown-content">
                <a href="list.php?group=Advisors&department=Financial%20Aid">Financial Aid</a>
                <a href="list.php?group=Advisors&department=Billing">Billing</a>
                <a href="list.php?group=Advisors&department=Health%20and%20Wellness">Health and Wellness</a>
            </div>
        </li>
        <li><a href="#">Contact</a></li>
        <?php if (!empty($_SESSION['loggedIn'])) {
            echo "<li><a href='calendar.php'>Calendar</a></li>";
            echo "<li><a href='settings.php'>Settings</a></li>";
            echo "<li><a href='logout.php'>Logout</a></li>";
        } ?>
    </ul>
</nav>
