<?php

if (!session_start())
{
    echo 'major error.';
    exit;
}

//if they are logged in as an employee, send to the the employee side of the store
if (isset($_SESSION['loggedin']))
{
    if ($_SESSION['loggedin'])
    {
        header("Location: ../../internal/login/successPage.php");
        exit;
    }
    // if they are not logged in, they must be a customer, so redirect to store home
    else
    {
        header("Location: ../");
        exit;
    }
}

//here it checks if there was an action specified, which it should be from the verify_form.php
$action = empty($_POST['action']) ? '' : $_POST['action'];

//here it looks to see if the login form was loaded, since the verify_form will sneakily set the action to 'do_login'
if ($action == 'do_login') {
    handle_login();
} else {
    //if not loaded, call function to load form
    display_form();
}

function display_form()
{
    include 'verify_form.php';
    exit;
}

// open database link object
function openDB()  {
    include "../../../CONFIG.php";
    $mysqli = new mysqli(HOSTNAME, USERNAME, PASSWORD, DATABASE);

    if($mysqli->connect_errno)  {
        echo "Couldn't connect to the database.";
        exit;
    }

    return $mysqli;
}

function handle_login()
{
    // post data
    $username = empty($_POST['username']) ? '' : $_POST['username'];
    $companyid = empty($_POST['CompanyID']) ? '' : $_POST['CompanyID'];

    $mysqli = openDB();

    // no injections plz
    $username = $mysqli->real_escape_string($username);
    $companyid = $mysqli->real_escape_string($companyid);

    // prepared statements yay
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare("SELECT Customer.UserID, CompanyID, FirstName, LastName
        FROM Customer, Person
        WHERE Customer.UserID=? AND CompanyID=?"))
    {
        echo "Error preparing statement: <br>";
        echo nl2br(print_r($stmt->error_list, true), false);
        exit;
    }

    // bind them
    if (!$stmt->bind_param('ss', $username, $companyid))
    {

        echo "Error binding parameters: <br>";
        echo nl2br(print_r($stmt->error_list, true), false);
        exit;
    }

    // execute
    $stmt->execute();

    // get results
    $result = $stmt->get_result();

    // fail if username and companyid doesn't match
    if ($result->num_rows != 1)
    {
        $error = 'UserID or CompanyID incorrect. <br> Note: New accounts are only created when reserving a rail car for the first time.';
        include 'verify_form.php';
        exit;
    }

    // get row from result
    $row = $result->fetch_assoc();

    // get UserID and hashed password into variables
    $UserID = $row['UserID'];
    $CompanyID = $row['CompanyID'];
    $firstname = $row['FirstName'];
    $lastname = $row['LastName'];
    $roles = 'x';   // no roles

    // close result
    $result->close();

    // close statement
    $stmt->close();

    // close database connection
    $mysqli->close();

    // put login into session
    $_SESSION['loggedin'] = false;  // NOTE: THE CUSTOMER IS NOT ABLE TO ACCESS EMPLOYEE-LEVEL STUFF DUE TO THIS BEING FALSE
    $_SESSION['name'] = $UserID;
    $_SESSION['companyid'] = $CompanyID;
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $_SESSION['roles'] = $roles;

    // redirect to previous page
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
