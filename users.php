<?php
require_once('Models/UsersDataSet.php');
//initialising error variables
$usernameError=$passwordError=$userTypeError=$generalError="";
$view = new stdClass();
$view->pageTitle = 'Users Information';


$usersDataSet = new UsersDataSet();
$view->UsersDataSet = $usersDataSet->fetchAllUsers(); //fetching users to display in table

if(isset($_POST['CreateUser']) ) { //if user pressed create
    if (empty($_POST["username"])) { //checking if each field isnt empty
        $usernameError = "Username is required";
    } elseif (empty($_POST['password'])) {
        $passwordError = " Password is required";
    } elseif (empty($_POST['userType'])) {
        $userTypeError = "User type is required";
    } else {
        $myUDSObject = new UsersDataSet();
        $username = htmlentities($_POST['username']);
        $user_type = htmlentities($_POST['userType']);
        $password = htmlentities($_POST['password']);
        if ($myUDSObject->checkUsername($username)) { //checking if username doesnt exist
            $usernameError = "username already exists";
        } else {
            $myUDSObject->signUp($username, $password, $user_type);//send inputted data to signUp()
        }
    }
}
if(isset($_POST['searchUser'])){
    if (empty($_POST["searchingParameter"])) { //checking if field isnt empty
        $generalError = "Field can't be empty";
    }else {
        $myUDSObject = new UsersDataSet();
        $parameter = htmlentities($_POST['searchingParameter']); //search using the result given via the form
        $searchResults = $myUDSObject->searchUsers($parameter); //send it through to the method
        $view->searchResults = $searchResults; //to view the result u get from the method
    }
}
require_once('Views/users.phtml');

