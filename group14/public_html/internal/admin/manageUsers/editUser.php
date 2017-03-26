<?php
require '../../login/loginCheck.php';

// quit if not an admin or not logged in
if (!$loggedIn || !($_SESSION['roles'] == 'a'))
{
    header("HTTP/1.1 403 Forbidden", true, 403);
    echo "You must be an administrator.";
    echo '<meta http-equiv="refresh" content="1; url=/~GROUP14/index.php">';
    exit;
}

function getUserData()
{
    if (!isset($_GET['name']))
    {
        echo "Error: No user specified. ";
        return;
    }

    require '../../../inc/utils.php';
    $mysqli = openDB();

    // prepare statement
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare("SELECT Authentication.UserID, Roles, FirstName, LastName, Graveyard
        FROM Authentication
        JOIN Person
        ON Person.UserID=Authentication.UserID
        WHERE Authentication.UserID=?"))
    {
        echo "Error preparing statement: <br>";
        echo nl2br(print_r($stmt->error_list, true), false);
        return;
    }

    // bind parameters
    if (!$stmt->bind_param('s', $_GET['name']))
    {
        echo "Error binding parameters: <br>";
        echo nl2br(print_r($stmt->error_list, true), false);
        return;
    }

    // execute statement
    if (!$stmt->execute())
    {
        echo "Error executing statement: <br>";
        echo nl2br(print_r($stmt->error_list, true), false);
        return;
    }

    // get results from query
    if (!$result = $stmt->get_result())
    {
        echo "Error getting result: <br>";
        echo nl2br(print_r($stmt->error_list, true), false);
        return;
    }

    if ($result->num_rows != 1)
    {
        echo "UserID incorrect. ";
        return false;
    }

    $row = $result->fetch_assoc();

    $result->free();
    $stmt->close();
    $mysqli->close();

    return $row;
}

// get user data as an array
$data = getUserData();
if (!isset($data) || !$data)
    die("UserID incorrect or database error.");

?>
<!DOCTYPE html>
<html lang="en">
    <head>
<?php include '../../../inc/meta.php'; ?>
        <title><?php echo $data['UserID']; ?> | Edit User</title>
    </head>
    <body>
<?php include '../../../inc/header.php'; ?>
        <main>
            <h1>Edit User &#8216;<?php echo $data['UserID']; ?>&#8217;</h1>
            <table>
                <thead>
                    <tr>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>UserID</th>
                        <th>Roles</th>
                        <th>Deleted?</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $data['LastName']; ?></td>
                        <td><?php echo $data['FirstName']; ?></td>
                        <td><?php echo $data['UserID']; ?></td>
                        <td><?php echo $data['Roles']; ?></td>
                        <td><?php echo $data['Graveyard']; ?></td>
                    </tr>
                </tbody>
            </table>
            <h2>User Options</h2>
<?php
if ($data['Graveyard'] == 0)
    echo '<p><a href="deleteUser.php?name=' . $data['UserID'] . '&do=true">Delete User</a></p>';
else
    echo '<p><a href="deleteUser.php?name=' . $data['UserID'] . '&do=false">Undelete User</a></p>';
?>
        </main>
<?php include '../../../inc/footer.php'; ?>
    </body>
</html>
