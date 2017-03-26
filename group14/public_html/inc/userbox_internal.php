<?php
// RegEx to not display login bar on certain pages
if (preg_match('/(login.php)|(createUser.php)/', $_SERVER['REQUEST_URI']))
{
    // instead, display the last time our database was edited
    echo 'DB Last Modified: ' . date("d M Y g:iA e", filemtime('/var/lib/mysql/group14'));
    return;
}
?>
<form action="/~GROUP14/internal/login/login.php" method="POST">
    <input type="hidden" name="action" value="do_login">
    <input type="text" id="username" name="username" autofocus placeholder="Username">
    <input type="password" id="password" name="password" placeholder="Password">
    <input type="submit" name="submit" value="Submit">
</form> 
