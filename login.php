<?php
    $title = 'User Login'; 

    require_once 'includes/header.php'; 
    require_once 'db/conn.php'; 
    
    //If data was submitted via a form POST request (aka the user entered their username/password into the form and it POSTed), then...
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Trim will remove whitespaces and we are also making it lowercase. It's easier then to ensure there's no dupliate usernames this way. (in the user.php code - getUser()).
        $username = strtolower(trim($_POST['username']));
        $password = $_POST['password'];
        // Hash/salt the password with the username as the salt to compare it to what's saved in the db. (Note that we are not de-hashing the password ever in the code, we just hash it when they enter it to see if it's a match to what's stored.)
        $new_password = md5($password.$username);

        // getUser checks if the username/password matches and returns true if so.
        $result = $user->getUser($username,$new_password);
        if(!$result){
            echo '<div class="alert alert-danger">Username or Password is incorrect! Please try again. </div>';
        }else{
            // If the username/password was authenticated (it returned true), then we are setting the session username and id.
            // Our SESSION variables persist throughout the user session. We had to add the session_start(), which was included in a file in the header, so it's on every page.
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $result['id'];
            // The user is then routed to the viewrecords.php screen:
            header("Location: viewrecords.php");
        }

    }
?>

<h1 class="text-center"><?php echo $title ?> </h1>

<!-- PHP-SELF - It means to submit the post request to this page and re-load this same page. (We are posting back to the same page basically.) htmlentities strips the text that is produced - removes malicious code. -->
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <table class="table table-sm">
            <tr>
                <td><label for="username">Username: * </label></td>
                <td><input type="text" name="username" class="form-control" id="username" value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') echo $_POST['username']; ?>">
                <!-- Above, if it's a POST action, meaning that the user entered their username/password, then the value will fill with the username that they previously submitted. This is so it's there in case they submitted their username/password and it didn't match. So they are staying on this page as they aren't authenticated yet. -->
                </td>
            </tr>
            <tr>
                <td><label for="password">Password: * </label></td>
                <td><input type="password" name="password" class="form-control" id="password">
                </td>
            </tr>
        </table><br/><br/>
        <input type="submit" value="Login" class="btn btn-primary btn-block"><br/>
        <a href="#"> Forgot Password </a>
            
    </form><br/><br/><br/><br/>

<?php include_once 'includes/footer.php'?>