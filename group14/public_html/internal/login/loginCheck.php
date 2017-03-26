<?php

if(!session_start()) {
    // If the session couldn't start, present an error
    header("Location: error.php");
    exit;
}

if (session_status() == PHP_SESSION_NONE) {

}
else  {

}


// got rid of ternary operator for clarity
if (empty($_SESSION['loggedin'])) {
    $loggedIn = false;
}
else {
    $loggedIn = $_SESSION['loggedin'];
    //$name = $_SESSION['name'];
}

?>
