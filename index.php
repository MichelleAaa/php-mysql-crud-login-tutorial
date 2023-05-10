    <!--note that every PHP file must have an index.php, as the server will look for this first.  -->
<?php
    $title = 'Index'; 
// Require will stop the website until it's done, and it will be a problem if it doesn't work.
// require_once will make sure it only includes it once. For example, if you accidentally required the same file twice, it will ignore the second require_once statement.
    require_once 'includes/header.php'; 
    require_once 'db/conn.php'; 

    // Calls the getSpecialities method from the crud object so we can access them below in the select section.
    $results = $crud->getSpecialties();

?>                         
    <!-- 
        - First name
        - Last Name
        - Date of Birth (Use DatePicker)
        - Specialty (Database Admin, SOftware Developer, Web Administrator, Other)
        - Email Address
        - Contact Number
    -->
    <h1 class="text-center">Registration for IT Conference </h1>
    <!-- When using a form with the GET method: It passes all the values in the URL, which isn't safe for important information. -->

    <!-- Using the post method, when we submit the form the data doesn't go into the URL anymore, as it did with GET as the method. -->
    <!-- The action page is where the user will be routed to once the form is submitted. -->
    <form method="post" action="success.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="firstname">First Name</label>
            <input required type="text" class="form-control" id="firstname" name="firstname">
        </div>
        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input required type="text" class="form-control" id="lastname" name="lastname">
        </div>
        <div class="form-group">
            <label for="dob">Date Of Birth</label>
            <input type="text" class="form-control" id="dob" name="dob">
        </div>
        <!-- https://jqueryui.com/datepicker/ is where we got the datepicker code from. We made sure the required links were included in the correct order to use it. -- The function is in the footer file. We did have a link for it in the heater file too. -->
        <div class="form-group">
            <label for="specialty">Area of Expertise</label>
            <select class="form-control" id="specialty" name="specialty">
                <!-- This will loop over all of the specialities returned above, and output an option for each name. -->
                <?php while($r = $results->fetch(PDO::FETCH_ASSOC)) {?>
                    <option value="<?php echo $r['specialty_id'] ?>"><?php echo $r['name']; ?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input required type="email" class="form-control" id="email"  name="email" aria-describedby="emailHelp" >
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-groupform-group">
            <label for="phone">Contact Number</label>
            <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phoneHelp" >
            <small id="phoneHelp" class="form-text text-muted">We'll never share your number with anyone else.</small>
        </div>
        <br/>
        <div class="custom-file">
            <!-- type="file" allows a file upload. When you click on it, it brings up the file upload folder for you to select what you want to upload. accept= is optional. It limits what's allowed to be uploaded. image/* means any type of image only. (jpg, png, etc.) -- Now in the file folder uploader it only shows the file folders and image files. -->
            <input type="file" accept="image/*" class="custom-file-input" id="avatar" name="avatar" >
            <label class="custom-file-label" for="avatar">Choose File</label>
            <small id="avatar" class="form-text text-danger">File Upload is Optional</small>

        </div>
        
        
        <button type="submit" name="submit" class="btn btn-primary btn-block">Submit</button>
    </form>
<br>
<br>
<br>
<br>
<br>
<?php require_once 'includes/footer.php'; ?>