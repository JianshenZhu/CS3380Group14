<nav>
    <ul>
        <li><a href="/~GROUP14/index.php">Home</a></li>
        <li><a href="/~GROUP14/log.php">Activity Log</a></li>
        <li><a href="/~GROUP14/internal/">Employees</a></li>
        <li>The Missouri Rail</li>
        <li>
<?php
if (isset($loggedIn) and $loggedIn)
    include 'userbox_internal_authed.php';
else
    include 'userbox_internal.php';
?>
        </li>
    </ul>
</nav>
