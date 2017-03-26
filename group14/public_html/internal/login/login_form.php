<!DOCTYPE html>
<html lang="en">
        <head>
<?php include '../../inc/meta.php'; ?>
                <title>Database login form</title>
                <style>
                </style>
        </head>
        <body>
<?php include '../../inc/header.php'; ?>
            <main>
                <!--the action here is key because it is where all this form data is being sent,
                    login.php determines if this value is set-->
                <form action="login.php" method="POST">
                    <fieldset>
                        <legend>Log In</legend>

                        <!--sneaky way of doing this, but gives the action attribute a value of do_login,
                                value could be anything as long as its the same in login.php-->
                        <input type="hidden" name="action" value="do_login">

                        <div>   
                                <!-- value here is grabbed from login.php so the user can enter the wrong password and not need to
                                        reenter the username-->
                                <input type="text" id="username" name="username" autofocus value="<?php print $username; ?>" placeholder="Username">
                        </div>

                        <div>
                                <input type="password" id="password" name="password" placeholder="Password">
                        </div>

<?php
if ($error) {
    print "<div>" . $error . "</div>\n";
}
?>

                        <div>
                                <input type="submit" value="Submit">
                        </div>
                    </fieldset>
                </form>
                <p><a href="/~GROUP14/internal/createUser/createUser.php">Need an Account?</a></p>
      </main>
<?php include '../../inc/footer.php'; ?>
        </body>
</html>

