<?php
    $title = 'Success'; 
    require_once 'includes/header.php'; 
    require_once 'db/conn.php';
    // conn initiates the connection and then starts up the crud (after requiring other db files). Now below, we are able to use crud later in the file.
    // It's set up this way so we don't have too much PHP database logic in one place.
    require_once 'sendemail.php';

    // This is a way to check if a variable exists on a page. (Whether it's empty or not is irrelevant to isset().)
    if(isset($_POST['submit'])){
        //extract values from the $_POST array
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $contact = $_POST['phone'];
        $specialty = $_POST['specialty'];

        
        $orig_file = $_FILES["avatar"]["tmp_name"]; //This is the original name coming through our post request. -- We called it avatar there.
        // php generates a temporary name before it's moved. So we have to reference it by the tmp_name attribute.
        $ext = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
        // target_dir is the uploads folder.
        $target_dir = 'uploads/';
        // We don't want one person's photo to over-ride another person's due to having the same file name. So here we are adding in their $contact number so it's always going to be unique. uploads/picturename124434353.php is an example of what this would output:
        // Note also that if someone re-uploads, becuase we are using the phone number, it would replace a pre-existing file that has the same url and file type extension.
        $destination = "$target_dir$contact.$ext";
        move_uploaded_file($orig_file,$destination); // This takes the file to be moved, and secondly, the destination.

        //Call inerstAttendees() function from the crud class to insert and track if success or not (We set it to return true if it's successful and false if the catch block runs.)
        // We have to pass $destination into the function so the optional picture url can be saved to the database. 
        $isSuccess = $crud->insertAttendees($fname, $lname, $dob, $email,$contact,$specialty,$destination);
        $specialtyName = $crud->getSpecialtyById($specialty);
        
        if($isSuccess){
            // Class is SendEmail, public static function is SendMail(). This is allowed for a static public class, that you don't need to create an instance of the class in order to call the functions in that class.
            SendEmail::SendMail($email, 'Welcome to IT Conference 2019', 'You have successfully registerted for this year\'s IT Conference');
            include 'includes/successmessage.php';
        }
        else{
            include 'includes/errormessage.php';
        }

    }
?>
    
    <!-- This prints out values that were passed to the action page using method="get" -->
    <!-- <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">

//note that when the form is submitted, the $_GET method is getting back the value submitted in the form. We can access the specific inputs by name with bracket [] notation.

                <?php //echo $_GET['firstname'] . ' ' . $_GET['lastname'];  ?>
            </h5>
            <h6 class="card-subtitle mb-2 text-muted">
                <?php //echo $_GET['specialty'];  ?>    
            </h6>
            <p class="card-text">
                Date Of Birth: <?php //echo $_GET['dob'];  ?>
            </p>
            <p class="card-text">
                Email Adress: <?php //echo $_GET['email'];  ?>
            </p>
            <p class="card-text">
                Contact Number: <?php //echo $_GET['phone'];  ?>
            </p>
    
        </div>
    </div> -->

    <!-- This prints out values that were passed to the action page using method="post" -->
    <!-- Here we are displaying the image that was uploaded and saved. We pull in the destination for the src: -->
    <img src="<?php echo $destination; ?>" class="rounded-circle" style="width: 20%; height: 20%" />
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">
                <?php echo $_POST['firstname'] . ' ' . $_POST['lastname'];  ?>
            </h5>
            <h6 class="card-subtitle mb-2 text-muted">
                <?php echo $specialtyName['name'];  ?>    
            </h6>
            <p class="card-text">
                Date Of Birth: <?php echo $_POST['dob'];  ?>
            </p>
            <p class="card-text">
                Email Adress: <?php echo $_POST['email'];  ?>
            </p>
            <p class="card-text">
                Contact Number: <?php echo $_POST['phone'];  ?>
            </p>
    
        </div>
    </div>
    

<br>
<br>
<br>
<br>
<br>
<?php require_once 'includes/footer.php'; ?>