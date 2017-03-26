<?php

function list_trains()
{
    require '../CONFIG.php';

    // open link to database
    if (!$link = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE))
    {
        return 'mysqli_connect() failed.';
    }

    // prepared statement
    if (!$stmt = mysqli_prepare($link, "
        SELECT Train.TrainNumber, Train.DepartureTime, Train.DepartureDate, Dep.Name, Dest.Name
        FROM Train
        JOIN Departure
        ON Departure.TrainNumber=Train.TrainNumber
        JOIN Location Dep
        ON Dep.ZIP=Departure.ZIP AND Dep.Address=Departure.Address
        JOIN Destination
        ON Destination.TrainNumber=Train.TrainNumber
        JOIN Location Dest
        ON Dest.ZIP=Destination.ZIP AND Dest.Address=Destination.Address
        WHERE Train.DepartureDate > CURRENT_DATE
        "))
    {
        return 'mysqli_prepare() failed. Check the query.';
    }

    // execute query
    // stmt now holds the result
    if (!mysqli_stmt_execute($stmt))
    {
        return 'mysqli_stmt_execute() failed.';
    }

    // pass statement into get_result()
    if (!$result = mysqli_stmt_get_result($stmt))
    {
        return 'mysqli_stmt_get_result() failed.';
    }

    // get row as an array
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
    {
        echo "<tr>\n";
        echo "<td>" . $row[0] . "</td>\n";
        echo "<td>" . $row[1] . "</td>\n";
        echo "<td>" . $row[2] . "</td>\n";
        echo "<td>" . $row[3] . "</td>\n";
        echo "<td>" . $row[4] . "</td>\n";
        echo "</tr>\n";
    }

    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
<?php include 'inc/meta.php'; ?>
        <title>Train Schedule</title>
    </head>
    <body>
<?php include 'inc/header.php'; ?>
        <main>
            <table class="schedule">
                <caption>Trains in DB with relevant date</caption>
                <thead>
                    <tr>
                        <th>Train Number</th>
                        <th>Departure Time</th>
                        <th>Departure Date</th>
                        <th>Departing From</th>
                        <th>Destination</th>
                    </tr>
                </thead>
                <tbody>
<?php
echo list_trains();
?>
                </tbody>
            </table>
        </main>
<?php include 'inc/footer.php'; ?>
    </body>
</html>
