<!DOCTYPE html>
<html lang="en">
    <head>
<?php include 'inc/meta.php'; ?>
        <link rel="stylesheet" href="/~GROUP14/css/landing.css">
        <link rel="shortcut icon" href="img/MRR.ico" />
        <title>Welcome to The Missouri Rail</title>
    </head>
    <body>
        <main id="landing">
            <article id="landing-article">
                <h1>The Missouri Rail</h1>
                <section id="landing-store">
                    <h2>Shop Railcars</h2>
                    <p>Simple, Easy, Elegant</p>
                    <p><a href="/~GROUP14/store/index.php">Enter the Store</a></p>
                    <p>
                        <form action="store/verify/verify.php" method="POST" id="landing-verify">
                            <input type="hidden" name="action" value="do_login">
                            <input type="text" name="username" placeholder="Vendor?">
                            <input type="text" name="CompanyID" placeholder="CompanyID">
                            <input type="submit" name="submit" value="Submit">
                        </form>
                    </p>
                </section>
                <section id="landing-login">
                    <h2><a href="/~GROUP14/internal/">Employee Facing Content</a></h2>
                    <p><a href="/~GROUP14/internal/login/login.php">Login as Employee</a></p>
                    <p><a href="/~GROUP14/internal/createUser/createUser.php">Register Employee</a></p>
                    <p><a href="/~GROUP14/img/erd.png">View ERD</a></p>
                </section>
            </article>
        </main>
    </body>
</html>
