<?php
//initialising error variables
$usernameError=$passwordError=$userTypeError=$spamError="";
$view = new stdClass();
$view->pageTitle = 'SignUppage';
require_once ('Models/UsersData.php');
require_once('Models/UsersDataSet.php');

if(isset($_POST['SignUp']) ){ //if user clicks sign up
    if(!empty($_POST['honeypot'])){ //if antispam honeypot is filled
        $spamError="spam detected"; //donot let them sign up, display error message instead
    }
    elseif (empty($_POST["username"])) { //error message for checking fields are not empty
            $usernameError = "Username is required";
        }
        elseif(empty($_POST['password'])){
            $passwordError=" Password is required";
        }
        elseif(empty($_POST['userType'])){
            $userTypeError="User type is required";
        }
    else {
        $myUDSObject = new UsersDataSet();
        $username = htmlentities($_POST['username']);
        $user_type = htmlentities($_POST['userType']);
        $password = htmlentities($_POST['password']);


        if ($myUDSObject->checkUsername($username)){ //checking if username is unique
            $usernameError="username already exists";
        }else{
        $myUDSObject->signUp($username, $password, $user_type);//send inputted data to signUp()

        header("Location: index.php"); //redirect to login page after sign up
        exit();}
    }

}

require ("Views/signup.phtml" );

