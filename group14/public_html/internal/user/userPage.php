<?php
include "../login/loginCheck.php";

if(!$loggedIn)  {
    header("Location: ../login/login.php");
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
        <link rel="shortcut icon" href="../../img/MRR.ico" />
        <title><?php echo $_SESSION['name'] . " User Page - Missouri Rail"; ?></title>
    </head>
    <body>
<?php include '../../inc/header.php'; ?>
        <main>
            <h1><?php echo $_SESSION['name']; ?></h1>
            <p style="color: red;"><?php echo nl2br(print_r($_SESSION, true), false); ?></p>
            <p><?php
if ($_SESSION['roles'] == 'a')
{
    echo "<strong>{$_SESSION['name']}</strong> is an administrator.<br>";
    echo "<a href='/~GROUP14/internal/admin/'>Admin Tools</a>";
}
?></p>
            <a href="/~GROUP14/internal/login/logout.php" class="logout">log out</a>
        </main>
<?php include '../../inc/footer.php'; ?>
    </body>
</html>
