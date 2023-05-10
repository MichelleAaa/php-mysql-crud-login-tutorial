<?php 

// The user won't really see the editpost.php page. If all goes well, they will get re-directed to index.php. If all doesn't go well, then they will see an error message.
    require_once 'db/conn.php';
    //Get values from post operation
    // The form is in edit.php. It pulled in data so it could be edited and the form re-submitted for the record to be updated.
    if(isset($_POST['submit'])){
        //extract values from the $_POST array
        $id = $_POST['id'];
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $contact = $_POST['phone'];
        $specialty = $_POST['specialty'];

        //Call Crud function
        $result = $crud->editAttendee($id,$fname, $lname, $dob, $email,$contact,$specialty);
        // Redirect to index.php
        if($result){
            // Header takes a string with the word location followed by the page route.
            header("Location: viewrecords.php");
        }
        else{
            include 'includes/errormessage.php';
        }
    }
    else{
        include 'includes/errormessage.php';
    }

    

?>