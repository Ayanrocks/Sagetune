<?php
include ("includes/config.php");
    include ("includes/classes/Account.php");
    include ("includes/classes/Constants.php");

    $account = new Account($con);


    include ("includes/handlers/register-handler.php");
    include ("includes/handlers/login-handler.php");

    function getinput ($name)
    {
        if(isset($_POST[$name])) {
            echo $_POST[$name];
        }
    }

?>
<script>if (screen.width <= 1000) {
        document.location = "./mobile.html";
    }</script>

    <!doctype html>



    <html>

    <head>
        <title>Register: Sagetune</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0">
        <link rel="shortcut icon" href="assets/images/favicon/favicon.ico" type="image/x-icon">
        <link rel="icon" href="assets/images/favicon/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/register.css">

        <!-- jquery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="assets/js/register.js"></script>

    </head>

    <body>
        <?php
if(isset($_POST['registerButton']))
{ 
    echo '<script>
            $(document).ready(function () {

                $("#loginform").hide();
                $("#registerform").show();


            });
        </script>';
        }
        else 
        { 
    echo '<script>
            $(document).ready(function () {

                $("#loginform").show();
                $("#registerform").hide();


            });
        </script>';
        }
?>
            <div id="background">
                <div id="logincontainer">
                    <div id="inputContainer">

                        <!--       login form    -->

                        <form action="register.php" method="post" id="loginform">
                            <h2>Login to your account</h2>

                            <p>
                                <?php  echo $account->getError(Constants::$loginfailed); ?>

                                <label for="loginUsername">Username </label>
                                <input type="text" id="loginUsername" name="loginUsername" placeholder="Enter your Username" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter your Username'" value="<?php   getinput('loginUsername'); ?>"
                                    required>
                            </p>
                            <p>
                                <label for="loginPassword">Password </label>
                                <input type="password" id="loginPassword" name="loginPassword" placeholder="Enter your password" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter your password'" required>
                            </p>
                            <button type="submit" name="loginButton">Log in</button>

                            <div class="hasAccount">
                                <span id="hidelogin">Don't have an account yet? Sign Up Now </span>
                            </div>
                        </form>




                        <!--        Register form     -->


                        <form action="register.php" method="post" id="registerform">
                            <h2>Create your Free Account</h2>
                            <p>
                                <?php  echo $account->getError(Constants::$fninvalid); ?>
                                <label for="fname">First Name </label>
                                <input type="text" id="fname" name="fname" placeholder="Enter your First Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your First Name'"
                                    value="<?php   getinput('fname'); ?>" required>
                            </p>
                            <p>
                                <?php  echo $account->getError(Constants::$lninvalid); ?>
                                <label for="lname">Last Name </label>
                                <input type="text" id="lname" name="lname" placeholder="Enter your Last Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your Last name'"
                                    value="<?php   getinput('lname'); ?>" required>
                            </p>
                            <p>
                                <?php
                    echo $account->getError(Constants::$uninvalid);
                    echo $account->getError(Constants::$usernameTaken);
                    ?>
                                    <label for="username">Username </label>
                                    <input type="text" id="username" name="username" placeholder="Enter your Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your Username'"
                                        value="<?php   getinput('username'); ?>" required>
                            </p>
                            <p>
                                <?php  echo $account->getError(Constants::$eminvalid); ?>
                                <?php  echo $account->getError(Constants::$emailTaken); ?>
                                <label for="email">Email </label>
                                <input type="email" id="email" name="email" placeholder="Enter your Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your Email'"
                                    value="<?php   getinput('email'); ?>" required>
                            </p>
                            <p>
                                <?php  echo $account->getError(Constants::$pwinvalid);
                    echo $account->getError(Constants::$pwoverflow);

                    ?>
                                <label for="password">Password </label>
                                <input type="password" id="password" name="password" placeholder="Enter your password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your password'"
                                    required>
                            </p>
                            <p>
                                <?php echo $account->getError(Constants::$pwmismatch);

                    ?>
                                <label for="password">Confirm Password </label>
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Retype the password" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Retype the password'" required>
                            </p>
                            <span id="message"></span>

                            <p>
                                <label for="dob">Date of birth </label>
                                <input type="date" id="dob" name="dob" placeholder="Enter your Date of Birth" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your Date of Birth'"
                                    value="<?php   getinput('dob'); ?>" required>
                            </p>
                            <p>
                                <?php  echo $account->getError(Constants::$phoneinvalid);
                  echo $account->getError(Constants::$phoneinv);

                  ?>
                                <label for="pno">Phone Number</label>
                                <input type="text" id="pno" name="phone" placeholder="Enter your 10 digit nummber" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your 10 digit nummber'"
                                    value="<?php   getinput('phone'); ?>" required>
                            </p>
                            <button id="registerbutton" type="submit" name="registerButton">Register</button>
                            <div class="hasAccount">
                                <span id="hideregister">Have an account already. Login Now </span>
                            </div>
                        </form>
                    </div>

                    <div id="logintext">
                        <h1>Music for Anytaste Anywhere, Anytime</h1>
                        <h2>Listen Now For Free</h2>
                        <ul>
                            <li>
                                <img src="https://png.icons8.com/ultraviolet/50/000000/checkmark.png">Discover trending Music you'll fall in love with </li>
                            <li>
                                <img src="https://png.icons8.com/ultraviolet/50/000000/checkmark.png">Create your own playlists</li>
                            <li>
                                <img src="https://png.icons8.com/ultraviolet/50/000000/checkmark.png">Follow artist to keep updated</li>
                        </ul>
                    </div>


                </div>

                <p id="photocc">Photo by Toa Heftiba on Unsplash</p>
                <p id="me">Designed By Ayan Banerjee</p>

            </div>

    </body>

    </html>


