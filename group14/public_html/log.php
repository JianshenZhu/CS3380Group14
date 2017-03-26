<?php
// check if logged in to internal
require 'internal/login/loginCheck.php';


// returns statement based on permissions
// the statement needs to be bound before querying
function getQuery($roles)
{
    switch ($roles)
    {
        // select for all user id's
        case 'a':
            return "SELECT LogNumber, IP, LogDate, LogTime, ActionKey, UserID
                FROM LogEntry";
            break;
        // select based on userid (userid must be bound)
        // or all actions related to the userid
        case 'c':
        case 'e':
            return "SELECT LogNumber, IP, LogDate, LogTime, ActionKey, UserID
                FROM LogEntry
                WHERE UserID=? OR ActionKey LIKE ?";
            break;
        // select all actions from a company based on a given userid
        default:
            return "SELECT LogNumber, IP, LogDate, LogTime, ActionKey, LogEntry.UserID
                FROM LogEntry
                WHERE LogEntry.UserID IN
                (
                    SELECT UserID
                    FROM Customer
                    WHERE CompanyID IN
                    (
                        SELECT CompanyID
                        FROM Customer
                        WHERE UserID=?
                    )
                )";
            break;
    }
}

// returns bound statement based on roles and userid
function getSTMT($mysqli, $roles, $userid)
{
    // initialize new statement
    $stmt = $mysqli->stmt_init();

    // prepare statement based on roles
    if (!$stmt->prepare(getQuery($roles)))
    {
        echo "Error preparing statement: <br>";
        echo nl2br(print_r($stmt->error_list, true), false);
        exit;
    }

    // bind parameters based on roles
    switch ($roles)
    {
        // no parameters needed for admin query
        case 'a':
            break;
        // userid needed twice for engineers and conductors
        case 'c':
        case 'e':
            $like = '%' . $userid . '%';
            $stmt->bind_param('ss', $userid, $like);
            break;
        // userid needed once for customers
        default:
            $stmt->bind_param('s', $userid);
            break;
    }

    // fail on error
    if ($stmt->errno)
    {
        echo "Error binding parameters: <br>";
        echo nl2br(print_r($stmt->error_list, true), false);
        exit;
    }

    return $stmt;
}

// displays log based on userid and roles
function displayLog($roles_given, $userid_given, $is_internal)
{
    // new database object
    include 'inc/utils.php';
    $mysqli = opendb();

    // new statement
    $stmt = getSTMT($mysqli, $roles_given, $userid_given);

    // execute and store results
    if (!$stmt->execute())
    {
        echo "Error executing query: <br>";
        echo nl2br(print_r($stmt->error_list, true), false);
        exit;
    }
    if (!$stmt->store_result())
    {
        echo "Error storing results: <br>";
        echo nl2br(print_r($stmt->error_list, true), false);
        exit;
    }

    // bind results
    $num_rows = $stmt->num_rows;
    if (!$stmt->bind_result($logid, $ip, $logdate, $logtime, $actionkey, $userid))
    {
        echo "Error binding results: <br>";
        echo nl2br(print_r($stmt->error_list, true), false);
        exit;
    }

    // get field names
    $metaResults = $stmt->result_metadata();
    $fields = $metaResults->fetch_fields();

    // print table header
    echo "<table>\n";
    echo "<caption>Log for <strong>$userid_given</strong> with roles <strong>$roles_given</strong></caption>\n";
    echo "<thead>\n";
    echo "<tr>\n";
    foreach ($fields as $field)
    {
        echo "<th>$field->name</th>\n";
    }
    echo "</tr>\n";
    echo "</thead>\n";

    // print table body
    echo "<tbody>\n";
    while ($stmt->fetch())
    {
        echo "<tr>\n";
        echo "<td>$logid</td>\n";
        echo "<td>$ip</td>\n";
        echo "<td>$logdate</td>\n";
        echo "<td>$logtime</td>\n";
        echo "<td>$actionkey</td>\n";
        echo "<td>$userid</td>\n";
        echo "</tr>\n";
    }
    echo "</tbody>\n";
    echo "</table>\n";

    // done!
    $stmt->free_result();
    $stmt->close();
    $mysqli->close();

    return;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
<?php include 'inc/meta.php'; ?>
        <link rel="shortcut icon" href="img/MRR.ico" />
        <title>Activity Log</title>
    </head>
<?php include 'inc/header.php'; ?>
    <body>
        <main>
<?php
// employees
if (isset($loggedIn) && $loggedIn)
{
    displayLog($_SESSION['roles'], $_SESSION['name'], 1);
}
// vendors
else if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false)
{
    displayLog($_SESSION['roles'], $_SESSION['name'], 0);
}
// guests
else
{
    echo '<p>Log is only viewable to registered employees or logged-in vendors.</p>';
    echo '<p><a href="store/">Return to Store</a></p>';
}
?>
        </main>
    </body>
<?php include 'inc/footer.php'; ?>
</html>
