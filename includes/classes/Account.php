<?php

    class Account {

        private $con;
        private $errorArray;
        public function __construct($con) {
            $this->con = $con;
            $this -> errorArray = array();
        }

        public function login($un, $pw)
        {
          $pw = md5($pw);

          $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND password='$pw'");
        
          if(mysqli_num_rows($query) == 1)
          {
            return true;
          }
          else
          {
            array_push($this->errorArray, Constants::$loginfailed);
            return false;
          }
        }

        public function register($un, $fn, $ln, $em, $pw, $pw2, $dob, $phone)
        {
            $this -> validateUsername ($un);
            $this -> validatefirstname ($fn);
            $this -> validatelastname ($ln);
            $this -> validateemail ($em);
            $this -> validatepassword ($pw, $pw2);
        
            $this -> validatephone ($phone);

            if(empty($this->errorArray) == true)
            {
                //insert into DB
                return $this->insertuserdetails($un, $fn, $ln, $em, $pw, $dob, $phone);

            }
            else {
                return false;
            }
        }




        public function getError($error)
        {
            if(!in_array($error, $this->errorArray)) {
                $error = "";
            }
            return "<span class='errorMessage'>$error</span>";
        }

        private function insertuserdetails($un, $fn, $ln, $em, $pw, $dob, $phone)
        {
          $encryptedpw = md5($pw);
          $profilepic = "assets/images/profile-pic/default.jpg";
          $date = date("Y-m-d");

          echo $this->phone;

          $result = mysqli_query($this->con, "INSERT INTO USERS VALUES ('', '$un','$fn','$ln', '$em', '$encryptedpw', '$date', '$dob', '$phone', '$profilepic')");
          return $result;
        }


            private function validateUsername ($un)
            {
                if(strlen($un) < 3 || strlen($un) > 25 )
                {
                    array_push($this->errorArray, Constants::$uninvalid );
                    return;
                }
                //username doesnt exist
                $checkusername = mysqli_query($this->con, "SELECT username FROM users WHERE username = '$un'");
                if(mysqli_num_rows($checkusername)!= 0)
                {
                  array_push($this->errorArray, Constants::$usernameTaken);
                  return;
                }


            }
            private function validatefirstname ($fn)
            {
                if(strlen($fn) < 3 || strlen($fn) > 25 )
                {
                    array_push($this->errorArray, Constants::$fninvalid);
                    return;
                }
            }
            private function validatelastname ($ln)
            {
            if(strlen($ln) < 2 || strlen($ln) > 25 )
                {
                    array_push($this->errorArray, Constants::$lninvalid);
                    return;
                }
            }
            private function validateemail ($em)
            {
                if(!filter_var($em, FILTER_VALIDATE_EMAIL))
                {
                    array_push($this->errorArray, Constants::$eminvalid);
                    return;
                }

//                check if the email hasnt been used
                  $checkemail = mysqli_query($this->con, "SELECT username FROM users WHERE email = '$em'");
                  if(mysqli_num_rows($checkemail)!= 0)
                  {
                    array_push($this->errorArray, Constants::$emailTaken);
                    return;
}
            }
            private function validatepassword ($pw , $pw2)
            {

                if(preg_match('/[^A-Za-z0-9]@#$/', $pw))
                {
                    array_push($this->errorArray, Constants::$pwinvalid);
                    return;
                }

                if(strlen($pw) < 6 || strlen($pw) > 30 )
                {
                    array_push($this->errorArray, Constants::$pwoverflow);
                    return;
                }
                if($pw != $pw2)
                {
                    array_push($this->errorArray, Constants::$pwmismatch);
                    return;
                }

            }
            private function validatephone ($phone)

            {
              
              if(strlen($phone) < 9 && strlen($phone) > 16)
              {
                array_push($this->errorArray, Constants::$phoneinvalid);
                return;
              }

              if(!is_numeric($phone))
              {
                array_push($this->errorArray, Constants::$phoneinv);
                return;
              }
            }

    }

?>
