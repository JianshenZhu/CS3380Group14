<?php

/*
 * Utility functions
 */


// opens link to database using Group14's defined information
function openDB()
{

    require '/home/GROUP14/CONFIG.php';

    // open link to database
    $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);
    if ($mysqli->connect_errno)
    {
        echo 'Could not connect to the database: (' . $mysqli->errno . ') ' . $mysqli->error;
        exit;
    }

    return $mysqli;
    
}

// gets client's IP
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

// inserts a row into LogEntry
// Note: there must be a 'name' in $_SESSION
function makeLog($actionKey) {

    if(!$actionKey)  {
    	echo "There is no action key!";
    	return;
    }
    
    $ip = get_client_ip();
    
    //echo $_SESSION['name'];

    $mysqli = openDB();

    // initialize new statement
    $stmt = $mysqli->stmt_init();

    //$query = "INSERT INTO LogEntry (UserID) SELECT UserID FROM Person WHERE UserID = ?";
    $query = "INSERT INTO LogEntry (UserID, IP, LogDate, LogTime, ActionKey) VALUES (?, ?, CURDATE(), CURTIME(), ?)";

    // prepare statement
    if (!$stmt->prepare($query))
    {
        echo "Error preparing statement: <br>";
        echo nl2br(print_r($stmt->error_list, true), false);
        return;
    }

    $stmt->bind_param('sss', $_SESSION['name'], $ip, $actionKey);

    if ($stmt->errno)
    {
        echo "Error binding parameters: <br>";
        echo nl2br(print_r($stmt->error_list, true), false);
        return;
    }

    if (!$stmt->execute())
    {
        echo "Error executing query: <br>";
        echo nl2br(print_r($stmt->error_list, true), false);
        return;
    }

    $stmt->close();
    $mysqli->close();

}

// displays a dynamic table my querying the database
function display_table($mysqli, $query, $tablename)
{

    // execute query
    if (!$result = $mysqli->query($query))
    {
        echo "Error executing statement: <br>";
        echo $mysqli->error;
        return;
    }

    // print table
    $fields = $result->fetch_fields();
    echo "\n<table>\n";
    echo "<caption>$tablename in DB</caption>\n";
    echo "<thead>\n";
    echo "<tr>\n";
    foreach ($fields as $field)
    {
        echo "<th>$field->name</th>";
    }
    echo "<tr>\n";

    echo "</thead>\n<tbody>\n";
    // get row as an array
    while ($row = $result->fetch_assoc())
    {
        echo "<tr>\n";
        foreach ($row as $key => $r)
        {
            echo '<td>';
            if ($key == 'UserID')
                echo "<a href='/~GROUP14/internal/admin/manageUsers/editUser.php?name=$r'>";
            echo $r;
            if ($key == 'UserID')
                echo '</a>';
            echo '</td>';
        }
        echo "</tr>\n";
    }

    // close table
    echo "</tbody>\n</table>\n";

    $result->free();
}

?>
