<!-- This file will hold all the CRUD operations
-->

<?php 
    class crud{

        // $db is proviate to the class, so the only way to interact with it is to use a function inside the crud class. If we set it to public then other functions outside of the crud class could interact with $db.
        private $db;
        
        //constructor to initialize private variable to the database connection
        function __construct($conn){
            // Sets db as the value passed in from $conn. (We use this call in the conn.php file, where after we get the connection we create an instance of the crud class, passing in the connection.)
            $this->db = $conn;
        }
        
        // function to insert a new record into the attendee database

        // This all will come from the POST option variables, which will get passed into this function when ran.
        public function insertAttendees($fname, $lname, $dob, $email,$contact,$specialty,$avatar_path){
            try {
                // define sql statement to be executed -- To get this easily, you can go into phpmyadmin, click on the table, SQL - insert -- it will give you a template of the INSERT INTO statement. (We omitted the id though becuase that's the primary key and it auto-increments itself.)
                // If you were going to insert them in the exact order of the DB you could just write INSERT INTO atendee VALUES (...). 
                // Note that for the values we have added : in front of the names to specify that we will fill those values dynamically, below.
                $sql = "INSERT INTO attendee (firstname,lastname,dateofbirth,emailaddress,contactnumber,specialty_id,avatar_path) VALUES (:fname,:lname,:dob,:email,:contact,:specialty,:avatar_path)";
                //prepare the sql statement for execution
                //We already defined our connection in conn, and it was passed into the $db variable. Here, within the crud class, we are calling the prepare() function and passing in the query we wrote above.
                $stmt = $this->db->prepare($sql);
                // bind all placeholders to the actual values
                // First value is the placeholder and second is the actual value. Within the statement that is being prepared, it replaces the placeholders with the values. 
                //This is an added level of protection against the sql injection attack.
                $stmt->bindparam(':fname',$fname);
                $stmt->bindparam(':lname',$lname);
                $stmt->bindparam(':dob',$dob);
                $stmt->bindparam(':email',$email);
                $stmt->bindparam(':contact',$contact);
                $stmt->bindparam(':specialty',$specialty);
                $stmt->bindparam(':avatar_path',$avatar_path);

                // execute statement
                $stmt->execute();
                return true;
        
            } catch (PDOException $e) {
                // At this point we want to see the error, so we are echo-ing instead of throwing an error: (Throwing would stop the execution, while this method doesn't.)
                echo $e->getMessage();
                return false;
            }
        }

        // In the editpost.php scren, we receive the details from the edit.php update form. We then call this function to send an update statement to the db:
        public function editAttendee($id,$fname, $lname, $dob, $email,$contact,$specialty){
            // Again, to get this, you can go to the dtabase in phpmyadmin, click on the table, SQL tab, then click UPDATE. It will give you a sample SQL UPDATE statement that you can copy/paste and then modify.
            try{ 
                $sql = "UPDATE `attendee` SET `firstname`=:fname,`lastname`=:lname,`dateofbirth`=:dob,`emailaddress`=:email,`contactnumber`=:contact,`specialty_id`=:specialty WHERE attendee_id = :id ";
                $stmt = $this->db->prepare($sql);
                // bind all placeholders to the actual values
                $stmt->bindparam(':id',$id);
                $stmt->bindparam(':fname',$fname);
                $stmt->bindparam(':lname',$lname);
                $stmt->bindparam(':dob',$dob);
                $stmt->bindparam(':email',$email);
                $stmt->bindparam(':contact',$contact);
                $stmt->bindparam(':specialty',$specialty);

                // execute statement
                $stmt->execute();
                return true;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
            
        }

        // If you go to the phpmyadmin page - databases, click on the database/table,browse tab -- That generates the start of the SQL code you can use for a SELECT statement so you can copy/paste it from there. (Or you could test out the select statements in phpmyadmin and once you are happy copy/paste it here)
        public function getAttendees(){
            try{
                $sql = "SELECT * FROM `attendee` a inner join specialties s on a.specialty_id = s.specialty_id";
                // $db has our connection to the db. We are calling the query() method from it.
                $result = $this->db->query($sql);
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        // The user goes to viewrecords.php. It renders out an anchor for each record that links to view.php and includes a query string at the end of the URL. That query string url id then will get passed into this function when called in view.php:
        public function getAttendeeDetails($id){
            try{
                $sql = "select * from attendee a inner join specialties s on a.specialty_id = s.specialty_id 
                where attendee_id = :id";
                $stmt = $this->db->prepare($sql);
                // After we prepare the statement, we bind the id which was passed in as a parameter.
                $stmt->bindparam(':id', $id);
                $stmt->execute();
                // The above executes our query. Becuase of that, we have to use fetch() to get that one. (When you are requesting all, as above in another function, we don't need fetch() but when you are only getting one, you need to follow up execute() with fetch())
                $result = $stmt->fetch();
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        public function deleteAttendee($id){
            try{
                $sql = "delete from attendee where attendee_id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':id', $id);
                $stmt->execute();
                return true;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        // This returns all the specialities. It's used in index.php so we can use a while loop to go through all the specialities and add them as options in the select field of the form.
        public function getSpecialties(){
            try{
                $sql = "SELECT * FROM `specialties`";
                $result = $this->db->query($sql);
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
            
        }

        public function getSpecialtyById($id){
            try{
                $sql = "SELECT * FROM `specialties` where specialty_id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
            
        }


        

    }
?>