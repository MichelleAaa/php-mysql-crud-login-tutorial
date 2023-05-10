<?php 

    class user{
        // private database object\
        private $db;
        
        //constructor to initialize private variable to the database connection
        function __construct($conn){
            $this->db = $conn;
        }

        public function insertUser($username,$password){
            try {
                // First, getUserbyUsername will run to see if there's already a user with the requested username.
                $result = $this->getUserbyUsername($username);
                // If there's a result over 0 then there's already a user in the db with this username.
                if($result['num'] > 0){
                    return false;
                } else{
                    // When we store the password in the db we don't want someone to be able to look into the db and see it. So we are using encryption. This is a password and salt. Sometimes people define a static salt so each time it's used as the second value. But in this case we are appending the $username as the salt.
                    // md5 is a built-in encyption function in php.
                    $new_password = md5($password.$username);
                    // define sql statement to be executed
                    // We don't need a value for ID as we set that up as auto-incrementing.
                    $sql = "INSERT INTO users (username,password) VALUES (:username,:password)";
                    //prepare the sql statement for execution
                    $stmt = $this->db->prepare($sql);
                    // bind all placeholders to the actual values
                    $stmt->bindparam(':username',$username);
                    $stmt->bindparam(':password',$new_password);
                    
                    // execute statement
                    $stmt->execute();
                    return true;
                }
                
        
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        // This will be used to verify if the username/password entered by the user is correct (aka it's already in the database.)
        public function getUser($username,$password){
            try{
                $sql = "select * from users where username = :username AND password = :password ";
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':username', $username);
                $stmt->bindparam(':password', $password);
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;
            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }

        // This is to make sure we don't enter two users with the same username. So this is just to check if the name already exists in the db.
        public function getUserbyUsername($username){
            try{
                $sql = "select count(*) as num from users where username = :username";
                $stmt = $this->db->prepare($sql);
                $stmt->bindparam(':username',$username);
                
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;
            }catch (PDOException $e) {
                    echo $e->getMessage();
                    return false;
            }
        }

        public function getUsers(){
            try{
                $sql = "SELECT * FROM users";
                $result = $this->db->query($sql);
                return $result;
            }catch(PDOException $e){
                echo $e->getMessage();
                return false;
            }
        }
    }
?>