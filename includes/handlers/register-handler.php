<?php



function sanitizeFormUsername ($inputText)
{
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    return $inputText;
}

function sanitizeFormString ($inputText)
{
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    $inputText = ucfirst(strtolower($inputText));
    return $inputText;
}



if(isset($_POST['registerButton']))
{
    $username  = sanitizeFormUsername($_POST['username']);
    $firstname  = sanitizeFormString($_POST['fname']);
    $lastname  = sanitizeFormString($_POST['lname']);
    $email  = sanitizeFormString($_POST['email']);
//        password
    $password = $_POST['password'];
    $password2 = $_POST['confirm_password'];
    $password =strip_tags($password);
    $password2 =strip_tags($password2);
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];



    $success = $account->register($username, $firstname, $lastname, $email, $password, $password2, $dob, $phone );

    if($success) {
      $_SESSION['userLoggedIn'] = $username;

        header("Location: index.php");
    }
}



?>
