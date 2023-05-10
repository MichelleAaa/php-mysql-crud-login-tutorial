<?php 
    require 'vendor/autoload.php';

    class SendEmail{
    // A public static function doesn't require us to instantiate an object. (We don't need to use new SendEmail(Data) -- We can access it another way.)
    // We wouldn't save the key here normally, only to simplify this example. (Often people make a .env file, then update autoload.php to load the key from the .env file.)
        public static function SendMail($to,$subject,$content){
            $key = 'get-the-api-key-from-sendgrid-after-setup';

            // This is coming from autoload.php (which is from our composer install of sendgrid).
            $email = new \SendGrid\Mail\Mail();
            // This will set details for the email, such as where it's being sent from, subject, etc..
            $email->setFrom("some-email-here@gmail.com", "Enterprise Name");
            $email->setSubject($subject);
            $email->addTo($to);
            // This is the body of the email. It requires the content type and the content itself. Plain is a regular string.
            $email->addContent("text/plain", $content);
            //$email->addContent("text/html", $content);

            $sendgrid = new \SendGrid($key);

            try{
                $response = $sendgrid->send($email);
                return $response;
            }catch(Exception $e){
                echo 'Email exception Caught : '. $e->getMessage() ."\n";
                return false;
            }
        }
    }
?>