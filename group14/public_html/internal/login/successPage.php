<?php

// this php block is something we would put at the top of every single one of our pages so that 	
// a login is required for all of them and no one can access it no matter what without a login
// even if they were to somehow get into the directory page
include "loginCheck.php";

if(!$loggedIn)  {
    header("Location: login.php");
}

else  {
    //echo "<li>" . $loggedIn . "</li>";
    //echo $_SESSION['name'];
}
?>




<!DOCTYPE html>
<html lang="en">
        <head>
<?php include '../../inc/meta.php'; ?> 
                <title>Success Page Boiii</title>
        </head>

        <body>
<?php include '../../inc/header.php'; ?>
        <main>
            <h1>Congratulations user!</h1>
            <p> You have just successfully logged in to our page.</p>
            <p>Please enjoy the content below until we can create this entire darn project.</p>
            <p>We appreciate your support for Missouri Rails Inc.</p>

            <p><?php echo "You are UserID:{$_SESSION['name']}, Name:{$_SESSION['firstname']} {$_SESSION['lastname']} , with permissions {$_SESSION['roles']}"; ?></p>
            <!--
            <iframe width="560" height="315" src="https://www.youtube.com/embed/VUFr4SK1-l4" style="border:none;" allowfullscreen></iframe>
            -->
            <iframe width="560" height="315" src="https://www.youtube.com/embed/Sn89CRaW6H0" style="border:none;" allowfullscreen></iframe>

        </main>
<?php include '../../inc/footer.php'; ?>
        </body>

</html>
