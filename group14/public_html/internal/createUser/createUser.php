<?php

// don't load page if they're logged in
include '../login/loginCheck.php';
if ($loggedIn)
{
    header("Location: ../login/successPage.php");
    exit;
}

//echo "at the top";
$action = empty($_POST['action']) ? '' : $_POST['action'];
//echo $action;
if ($action == 'make_new') {
    handle_create();
} 
else {
    new_form();
}

function new_form() {
    //$username = "";
    $error = "";
    require "createUser_form.php";
    exit;
}


function handle_create() {
    // secret code!
    define("SECRET", "guilliams");

    // get all vars from form
    $firstname = empty($_POST['firstname']) ? '' : $_POST['firstname'];
    $lastname = empty($_POST['lastname']) ? '' : $_POST['lastname'];
    $username = empty($_POST['username']) ? '' : $_POST['username'];
    $password = empty($_POST['password']) ? '' : $_POST['password'];
    $password_confirm = empty($_POST['password_confirm']) ? '' : $_POST['password_confirm'];
    $role = empty($_POST['role']) ? '' : $_POST['role'];
    $secret = empty($_POST['secret']) ? '' : $_POST['secret'];

    // verify secret code
    if (strcmp($secret, SECRET))
    {
        $error = "Secret Code is wrong.";
        include 'createUser_form.php';
        exit;
    }

    // empty fields not allowed
    if (empty($firstname) || empty($lastname) || empty($username) || empty($password) || empty($password_confirm) || empty($role))
    {
        $error = "Fields cannot be empty";
        include 'createUser_form.php';
        exit;
    }

    //$mysqli = openDB();

    //include "../../../CONFIG.php";
    //$mysqli = new mysqli($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);
    //$link= mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);
    include '../../inc/utils.php';  // contains openDB()
    $mysqli = openDB();
    if($mysqli->connect_errno)  {
        echo "Couldn't connect to the database";
        exit;
    }



    //include"encryptPassword.php";



    // http://php.net/manual/en/mysqli.real-escape-string.php
    $firstname = $mysqli->real_escape_string($firstname);
    $lastname = $mysqli->real_escape_string($lastname);
    $username = $mysqli->real_escape_string($username);
    $password = $mysqli->real_escape_string($password);
    $password_confirm = $mysqli->real_escape_string($password_confirm);
    $role = $mysqli->real_escape_string($role);

    // hash given password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // passwords must match
    if (!password_verify($password_confirm, $password_hashed))
    {
        $error = "Passwords must match.";
        include 'createUser_form.php';
        exit;
    }

    // destroy unhashed passwords
    unset($password);
    unset($_POST['password']);
    unset($password_confirm);
    unset($_POST['password_confirm']);


    // Build query
    //$query = "SELECT * FROM users WHERE userName = '$username'";

    // build statement
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare("SELECT UserID FROM Authentication WHERE UserID=?"))
    {
        echo "Error preparing statement: \n";
        print_r($stmt->error_list);
        exit;
    }

    // bind parameters
    if (!$stmt->bind_param('s', $username))
    {
        echo "Error binding parameters: \n";
        print_r($stmt->error_list);
        exit;
    }

    // Run the query
    //$result = $mysqli->query($query);

    // execute statement
    $stmt->execute();

    // get result
    $result = $stmt->get_result();

    // fail if username already in database
    if ($result->num_rows != 0)
    {
        $error = "Username $username is already in use.";
        include 'createUser_form.php';
        exit;
    }

    // close result and statement
    $result->close();
    $stmt->close();

    // build new statement to insert new user in Person table, Employee table, and Authentication table
    $stmt_person = $mysqli->stmt_init();
    $stmt_emp = $mysqli->stmt_init();
    $stmt_auth = $mysqli->stmt_init();
    // statement for type of employee
    $stmt_role = $mysqli->stmt_init();
    switch ($role)
    {
        case 'c':
            $query = "INSERT INTO Conductor (UserID) VALUES (?)";
            break;
        case 'e':
            $query = "INSERT INTO Engineer (UserID) VALUES (?)";
            break;
    }

    // prepare
    if (!$stmt_person->prepare("INSERT INTO Person (FirstName, LastName, UserID) VALUES (?,?,?)") ||
        !$stmt_emp->prepare("INSERT INTO Employee (UserID) VALUES (?)") ||
        !$stmt_auth->prepare("INSERT INTO Authentication (UserID, Password, Roles) VALUES (?,?,?)") ||
        !$stmt_role->prepare($query))

    {
        echo "Error preparing INSERT statement: \n";
        echo nl2br(print_r($stmt_person->error_list, true), false);
        echo nl2br(print_r($stmt_emp->error_list, true), false);
        echo nl2br(print_r($stmt_auth->error_list, true), false);
        echo nl2br(print_r($stmt_role->error_list, true), false);
        exit;
    }

    // bind parameters to new statement
    if (!$stmt_person->bind_param('sss', $firstname, $lastname, $username) ||
        !$stmt_emp->bind_param('s', $username) ||
        !$stmt_auth->bind_param('sss', $username, $password_hashed, $role) ||
        !$stmt_role->bind_param('s', $username))
    {
        echo "Error binding parameters to INSERT: \n";
        echo nl2br(print_r($stmt_person->error_list, true), false);
        echo nl2br(print_r($stmt_emp->error_list, true), false);
        echo nl2br(print_r($stmt_auth->error_list, true), false);
        echo nl2br(print_r($stmt_role->error_list, true), false);
        exit;
    }
    //print_r($result);
    
    // execute statement
    if (!$stmt_person->execute() ||
        !$stmt_emp->execute() ||
        !$stmt_auth->execute() ||
        !$stmt_role->execute())
    {
        echo "Error INSERTing: \n";
        echo nl2br(print_r($stmt_person->error_list, true), false);
        echo nl2br(print_r($stmt_emp->error_list, true), false);
        echo nl2br(print_r($stmt_auth->error_list, true), false);
        echo nl2br(print_r($stmt_role->error_list, true), false);
        exit;
    }

    // log in the user and makeLog
    $_SESSION['name'] = $username;
    $_SESSION['loggedin'] = true;
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $_SESSION['roles'] = $role;
    makeLog("CreateUser");

    // good job!
    $error = "Account created with UserID '$username'.";
    //include 'createUser_form.php';
    header("Location: ../login/successPage.php");

    /*
    // If there was a result...
    if ($result) {

        $match = $result->num_rows;

        // If there was a match, login
        if ($match == 1) {

            //echo "boy it was found";
            $error = 'The username <b>' . $_POST['username'] . '</b> is already in use';
            require "createUser_form.php";

            // Close the results
            $result->close();
            // Close the DB connection
            $mysqli->close();
            exit;

        }
        // Else, there was no result
        else {


            $query = "INSERT INTO users VALUES (?,?,?)";
            //echo $query;

            if($statement = mysqli_prepare($link, $query))  {
                //echo "inside statement";
                mysqli_stmt_bind_param($statement, "sss", $_POST['name'], $_POST['username'], $_POST['password']);
                //echo "parameters binded";
                if(mysqli_stmt_execute($statement))  {
                    //echo "executing statement";
                    $error = 'Your acount has been created <b>' . $_POST['name'] . 'with password' . $pass  . '</b>';
                    //echo "it happened";
                }
                else  {
                    $error = 'it didnt work';
                }
            }
            else  {
                $error = "couldn't prepare statement";
            }
        }		

        require "createUser_form.php";

        // Close the results
        $result->close();
        // Close the DB connection
        $mysqli->close();
        exit;
    }*/

}


?>

