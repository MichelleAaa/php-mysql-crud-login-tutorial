    
<?php
    $title = 'Edit Record'; 

    require_once 'includes/header.php'; 
    require_once 'includes/auth_check.php';
    require_once 'db/conn.php'; 

    $results = $crud->getSpecialties();

    // We don't want someone to be able to access edit.php without being sent there (as when they are sent here from viewerecords.php there's a query string added to the end.) So here we are setting it so that if there's no GET data then the person will be re-directed. 
    if(!isset($_GET['id']))
    {
        //echo 'error';
        include 'includes/errormessage.php';
        header("Location: viewrecords.php");
    }
    else{
        // If theres an ID in the query string parameter, this will put it in the $id variable.
        $id = $_GET['id'];
        $attendee = $crud->getAttendeeDetails($id);
    

    
?>

    <h1 class="text-center">Edit Record </h1>

    <form method="post" action="editpost.php">
        <!-- We set the value equal to the variable from the database. (That way the screen fills with the data that was already saved before. The user can then change the data and re-submit the form.) -->

        <!-- Note that we are using a POST request so we can't send the data in the url. Instead, we have created a hidden input type so we have the id in the form, it can be submitted and pulled out in editpost.php, but the user doesn't see it. -->
        <input type="hidden" name="id" value="<?php echo $attendee['attendee_id'] ?>" />
        <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" class="form-control" value="<?php echo $attendee['firstname'] ?>" id="firstname" name="firstname">
        </div>
        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" class="form-control" value="<?php echo $attendee['lastname'] ?>" id="lastname" name="lastname">
        </div>
        <div class="form-group">
            <label for="dob">Date Of Birth</label>
            <input type="text" class="form-control" value="<?php echo $attendee['dateofbirth'] ?>" id="dob" name="dob">
        </div>
        <div class="form-group">
            <label for="specialty">Area of Expertise</label>
            <!-- Note that for a select we have to make sure the selected value for the drop-down is shown. So we have to add an if statement to check if the speciality id printed by the while loop is the same as the one from the attendee array. If it is, then 'selected' is added to the option so it's shown as the current selection. -->
            <select class="form-control" id="specialty" name="specialty">
                <?php while($r = $results->fetch(PDO::FETCH_ASSOC)) {?>
                    <option value="<?php echo $r['specialty_id'] ?>" <?php if($r['specialty_id'] == $attendee['specialty_id']) echo 'selected' ?>>
                            <?php echo $r['name']; ?>
                    </option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" value="<?php echo $attendee['emailaddress'] ?>" name="email" aria-describedby="emailHelp" >
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="phone">Contact Number</label>
            <input type="text" class="form-control" id="phone" value="<?php echo $attendee['contactnumber'] ?>" name="phone" aria-describedby="phoneHelp" >
            <small id="phoneHelp" class="form-text text-muted">We'll never share your number with anyone else.</small>
        </div>
        
        <a href="viewrecords.php" class="btn btn-default">Back To List</a>
        <button type="submit" name="submit" class="btn btn-success">Save Changes</button>
    </form>

<?php } ?>
<br>
<br>
<br>
<br>
<br>
<?php require_once 'includes/footer.php'; ?>