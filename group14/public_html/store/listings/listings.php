<?php
	
    include "../../internal/login/loginCheck.php";

    if($loggedIn == false)  {
        //header("Location: ../../login/loginCheck.php;
        //exit;
        //dont know what to do here yet, may need it idk

    }
    else  {
    }
    
    
    
    function openDB()  {

    	include "../../../CONFIG.php";

        $mysqli = new mysqli($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

        if($mysqli->connect_errno)  {
            echo "Couldnt connect to the database";
            exit;
        }

        return $mysqli;

    }

    function makeQuery($sql, $mysqli)  {

    	$result = $mysqli->query($sql);

        echo "<table><tr>";

        while($fieldInfo = mysqli_fetch_field($result))  {
        	echo "<th>" . $fieldInfo->name . "</th>";
        }
        echo "</tr>";
        while($row = $result->fetch_array(MYSQLI_NUM))  {
            echo "<tr>";
            foreach($row as $value)  {
            	echo "<td>" . $value . "</td>";
        	}
            echo "</tr>";
        }
        echo "</table>";
    }
	
	$string = "SELECT * FROM Equipment ";
    
    $price = $_REQUEST["price"];
	$type = $_REQUEST["type"];
	$loc = $_REQUEST["loc"];
	
	$string = $string . "WHERE Price < " . $price;
	echo $string;
	//if type isnt empty add to string
	if($type != "")  {
		//$string = $string . " AND WHERE Type LIKE '" . $type . "%'";
		echo " AND WHERE Type LIKE '" . $type . "%'";
	}
	if($loc != "")  {
		//$string = $string . " AND WHERE loc LIKE '" . $loc . "%'";
		echo " AND WHERE loc LIKE '" . $loc . "%'";
	}
	
	echo "<br>Query string is: " . $string;
	
	$mysqli = openDB();
	
	makeQuery($string, $mysqli);
	

?>


