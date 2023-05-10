<?php
    // If the session is set with username (aka the person logged in), then this code will re-direct the person to login.php. We can include this code in files that we want to protect by requiring the user to already have logged in to access them.
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
?>