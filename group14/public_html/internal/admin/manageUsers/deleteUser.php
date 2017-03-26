<?php

include '../../login/loginCheck.php';
// quit if not an admin or not logged in
if (!$loggedIn || !($_SESSION['roles'] == 'a'))
{
    header("HTTP/1.1 403 Forbidden", true, 403);
    echo "You must be an administrator.";
    echo '<meta http-equiv="refresh" content="1; url=/~GROUP14/index.php">';
    exit;
}

// request values and validate
if (!isset($_GET['do']) || !isset($_GET['name']))
{
    echo "GET values incorrect.";
    echo '<meta http-equiv="refresh" content="1; url='. $_SERVER['HTTP_REFERER'] . '">';
    exit;
}
else
{
    // set $do to 1 if true, 0 otherwise
    // bind_param does not take booleans, so we have to use integers
    $do = strcmp($_GET['do'], 'true') == 0 ? 1 : 0;

    $name = $_GET['name'];
}

// query to delete or restore user
$query = "UPDATE Person SET Graveyard=? WHERE UserID=?";

// open database
include '../../../inc/utils.php';
$mysqli = openDB();

// prepare statement
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($query))
{
    echo "Error preparing statement: <br>";
    echo nl2br(print_r($stmt->error_list, true), false);
    return;
}

// bind username
if (!$stmt->bind_param('ss', $do, $name))
{
    echo "Error binding parameters: <br>";
    echo nl2br(print_r($stmt->error_list, true), false);
    return;
}

// query database
if (!$stmt->execute())
{
    echo "Error executing query: <br>";
    echo nl2br(print_r($stmt->error_list, true), false);
    return;
}

// done
$stmt->close();
$mysqli->close();

// log action
$actionkey = $do ? "DeleteUser {$_GET['name']}" : "RestoreUser {$_GET['name']}";
makeLog($actionkey);

// redirect to previous page
header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
?>
