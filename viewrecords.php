<?php
    $title = 'View Records'; 

    require_once 'includes/header.php'; // Header has the session_start(). 
    // Here we include the auth_check, so if the user is not logged in, they get re-directed instead of being able to access this page.
    require_once 'includes/auth_check.php';
    require_once 'db/conn.php'; 

    // Get all attendees -- Calls the getAttendees() method from the $crud variable (which is an instance of the crud class, instantiated in db/conn.php).
    $results = $crud->getAttendees();
?>


    <table class="table">
        <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Specialty</th>
            <th>Actions</th>
        </tr>
        <!-- $results above is an array. Below we are using a while loop to go through the array item by item. -->
        <!-- r is an arbitrary value. results was defined above. the -> arrow operator 
        for each item in the collection, results will come back in $results. For each thing that came back, r will embody that value. So for each value, we are generating a section of the table, a row.
    -->
        <?php while($r = $results->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
            <!-- Each has a value coming back from the database. Each time the loop iterates, it's going to store the result in r. Then in r, we can reference whatever values we need. -->
                <td><?php echo $r['attendee_id'] ?></td>
                <td><?php echo $r['firstname'] ?></td>
                <td><?php echo $r['lastname'] ?></td>
                <td><?php echo $r['name'] ?></td>
                <td>
                    <!-- This anchor tag woudl lead to view.php with a query string at the end with the id value. Whatever the attendee_id is for this record. -->
                    <a href="view.php?id=<?php echo $r['attendee_id'] ?>" class="btn btn-primary">View</a>
                    <a href="edit.php?id=<?php echo $r ['attendee_id'] ?>" class="btn btn-warning">Edit</a>
                    <!-- When the user clicks, they get a pop-up asking if they are sure. The user doesn't get re-routed to the delete.php page until they click confirm. -->
                    <a onclick="return confirm('Are you sure you want to delete this record?');" href="delete.php?id=<?php echo $r['attendee_id'] ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr> 
        <?php }?>
    </table>

<br>
<br>
<br>
<?php require_once 'includes/footer.php'; ?>