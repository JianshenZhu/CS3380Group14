<nav>
    <ul>
        <li><a href="/~GROUP14/index.php">Home</a></li>
        <li><a href="/~GROUP14/schedule.php">Train Schedule</a></li>
        <li><a href="/~GROUP14/log.php">Log</a></li>
<?php
if ($loggedIn && $_SESSION['roles'] == 'a')
    echo '<li><a href="/~GROUP14/internal/admin">Admin Tools</a></li>';
?>
        <li>The Missouri Rail</li>
        <li id="userbox">
<?php
if ($loggedIn)
    include 'userbox_internal_authed.php';
else
    include 'userbox_internal.php';
?>
        </li>
    </ul>
</nav>
