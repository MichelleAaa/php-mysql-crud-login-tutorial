<?php
// For a delete you could route to a page to ask for confirmation. But in this case we are just using this page to do the delete and then re-direct back to the viewrecords.php page. (So the user won't see the delete page if it's successful.)
    require_once 'includes/auth_check.php';
    require_once 'db/conn.php';

    if(!isset($_GET['id'])){
        include 'includes/errormessage.php';
        // If id doesn't exist in GET then the user will be re-routed to viewrecords.php.
        header("Location: viewrecords.php");
    }else{
        // Get ID values
        $id = $_GET['id'];

        //Call Delete function
        $result = $crud->deleteAttendee($id);
        //Redirect to list
        if($result)
        {
            // This will re-direct back to the viewrecords.php page.
            header("Location: viewrecords.php");
        }
        else{
            include 'includes/errormessage.php';
        }
    }

?>