<?php
    $title = 'View Record'; 

    require_once 'includes/header.php'; 
    require_once 'includes/auth_check.php';
    require_once 'db/conn.php'; 

    // Get attendee by id
    // This checks if there's an id query parameter in the url.
    if(!isset($_GET['id'])){
        include 'includes/errormessage.php';
        
    } else{
        // The user would end up at view.php after going to viewrecords.php and clicking on an anchor tag that includes view.php?id=(id here) -- so that's a GET request, and we can use $_GET to access the query parameter of id.
        $id = $_GET['id'];
        // Then we are calling the getAttendeeDetails() function from the $crud variable, which is an instance of the crud class that was instantiated in the conn.php file. $result will now include the details of that one record with matching id as provided.
        $result = $crud->getAttendeeDetails($id);
    
    
?>
<!-- We are using a ternary operator -- if there's no avatar_path, then we are loading blank.png, a stock blank avatar picture -->
<img src="<?php echo empty($result['avatar_path']) ? "uploads/blank.png" : $result['avatar_path'] ; ?>" class="rounded-circle" style="width: 20%; height: 20%" />

<div class="card" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title">
            <?php echo $result['firstname'] . ' ' . $result['lastname'];  ?>
        </h5>
        <h6 class="card-subtitle mb-2 text-muted">
            <?php echo $result['name'];  ?>    
        </h6>
        <p class="card-text">
            Date Of Birth: <?php echo $result['dateofbirth'];  ?>
        </p>
        <p class="card-text">
            Email Adress: <?php echo $result['emailaddress'];  ?>
        </p>
        <p class="card-text">
            Contact Number: <?php echo $result['contactnumber'];  ?>
        </p>

    </div>
</div>
<br/>
        <a href="viewrecords.php" class="btn btn-info">Back to List</a>
        <a href="edit.php?id=<?php echo $result['attendee_id'] ?>" class="btn btn-warning">Edit</a>
        <a onclick="return confirm('Are you sure you want to delete this record?');" href="delete.php?id=<?php echo $result['attendee_id'] ?>" class="btn btn-danger">Delete</a>
    <?php } ?>
<br>
<br>
<br>
<?php require_once 'includes/footer.php'; ?>