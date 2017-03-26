<!DOCTYPE html>
<html lang="en">
    <head>
<?php include '../../inc/meta.php'; ?>
        <title>Vendor Login</title>
    </head>
    <body>
<?php include '../../inc/header.php'; ?>
        <main>
            <h1>Log in to Customer Account</h1>
            <form action="verify.php" method="POST">
                <fieldset>
                    <legend>Enter Vendor Details</legend>
                    <input type="text" name="username" id="username" value=<?php
if (isset($_POST['username']))
    echo '"' . $_POST['username'] . '"';
else
    echo '"" autofocus';
?> placeholder="UserID">
                    <input type="text" name="CompanyID" id="CompanyID" autofocus placeholder="CompanyID">
                    <input type="submit" name="submit" value="Submit">
                </fieldset>
            </form>
        </main>
<?php include '../../inc/footer.php'; ?>
    </body>
</html>
