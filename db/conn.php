<?php 

    require_once 'includes/login_creds.php';
// NOTE: To make this work, we have already set up the mySQL database using the localhost/ myphpadmin database creator (in the browser)

// We are using pdo. you will also see mysql and mysqli APIs -- people are currently (at the time of this course) suggesting pdo as it's more secure. -- pdo also reduces the need to connect to the database everytime you want to do something with the data. You want to minimize how often someone has to connect to a database as it's expensive. 

// Development Connection
    // $host = '127.0.0.1'; // --- the database server is on localhost right now. there's two ways to write this. localhost or you could write 127.0.0.1
    // $db = 'attendance_db'; // --- the name of the db that we created in the myphpadmin panel.(The name is located in the left sidebar.)
    // $user = 'root'; // --- you can use root with no password and get through. That's the default user. 
    // $pass = ''; // --- the default is no password for root. If you were using mysql community edition it may be different. Some may require you to add a password at the time of use. -- but xampp and others often include root/no password.
    // $charset = 'utf8mb4'; // --- this is to say what type of symbols can be expected. This is the standard value you would enter for this field.

    //Remote Database Connection
    //MOVED TO: includes/login_creds.php

    // This is the way it connects to the database. It's short for data source name. 
    // Declare the driver, aka mysql (pdo supports different database, oracle, microsoft sql, etc.) 
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    try{ 
        // This attempts a connection to the db.
        $pdo = new PDO($dsn, $user, $pass);
        // The below line is not mandatory. It's optional to set additional requirements. In this case, we are setting the error mode (whenever there's an error, we want to see the error.)
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // if the try fails, the catch will run.
        // In other languages you can use just catch without (), but in this language you must include the () with catch()
        // this is watching to see if there's an error with the PDOException object. If there's a PDOException during the attempt, it will catch the error and catch the error data in a variable called $e.
    } catch(PDOException $e) {
        // the $e is an object. We are catching the exception object as $e and then using getMessage() to pull out the message from $e.
        // You could just echo the exception message but in this case we want to throw an exception since it won't run correctly without a db connection.
        throw new PDOException($e->getMessage());
    }

    // After setting up a successful connection, we want to include crud.php and user.php so we can immediately work with their classes.
    require_once 'crud.php';
    require_once 'user.php';
    // we are passing the $pdo object into crud, from crud.php, as the parameter.
    // above we required crud.php, and below we invoke a new instance of the crud class, passing in the variable, and now it's available for use and loaded with the pdo object data.
    $crud = new crud($pdo);
    $user = new user($pdo); 

    $user->insertUser("admin","password"); // If this runs twice, it's fine because the function will check for the username and return false instead of creating the credentials a second time.
?>