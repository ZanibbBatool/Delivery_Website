<?php
session_start();
$view = new stdClass();
$view->pageTitle = 'Homepage';

require_once('Models/UsersDataSet.php');
$usernameError=$passwordError=$loginError=$spamError=""; //initializing error variables

if (isset($_POST['Submit'])) {
    if(!empty($_POST['honeypot'])){ //if antispam honeypot is filled then do not allow login
       $spamError= "spam detected";
    }
    else {
            if (empty($_POST["username"])) {
                $usernameError = "Name is required"; //error if username empty
            }
            if(empty($_POST['password'])){
                $passwordError=" Password is required"; //error if password empty
            }

        $username = htmlentities($_POST['username']);
        $_SESSION['storedName'] = $username; //storing the inputted username in a session
        $loginPassword = htmlentities($_POST['password']);
        $myUDSObject = new UsersDataSet();
        $verificationLogin = $myUDSObject->verifyLogin($username, $loginPassword);
        if ($verificationLogin) {
            $myQuery = 'SELECT user_type FROM users WHERE username = :storedName';
            $myStatement = $myUDSObject->_dbHandle->prepare($myQuery);
            $myStatement->bindParam(':storedName', $username);
            $myStatement->execute(); //getting the user_type that corresponds with username

            $result = $myStatement->fetch();
            $loginUser_type = $result['user_type']; //storing the result in my own variable
            if ($loginUser_type === 'M') { //go to manager page if type is M

                header("Location: manager.php");
                exit();
            } elseif ($loginUser_type === 'D') { //go to deliverers page if type is D

                header("Location: deliverer.php");
                exit();
            }

        } else {
            $passwordError='invalid password'; //error if password verify is false
            $loginError="login failed";
        }
    }
}

require ("Views/index.phtml" );


