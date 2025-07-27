<?php
session_start();
require_once('Models/DeliveryPointDataSet.php');
require_once('Models/DeliveryPointData.php');
require_once ('Models/UsersData.php');
require_once ('Models/UsersDataSet.php');

$view = new stdClass();
$view->pageTitle = 'Parcel Information';
$generalError="";

if (isset($_POST['Logout'])) { //destroy the session once user logs out
    session_unset();
    session_destroy();
    header('Location:index.php');
}

//code to display the correct table records for each deliverer
$myDPDSObject = new DeliveryPointDataSet();
$sessionUsername=$_SESSION['storedName']; //getting the username of person who logged in from index

$myQuery='SELECT userid FROM users WHERE username = :storedName';//comparing the session username with the user id in my database
$myStatement = $myDPDSObject->_dbHandle->prepare($myQuery);
$myStatement->bindParam(':storedName', $sessionUsername);
$myStatement->execute(); //getting the userid that corresponds with username

$result = $myStatement->fetch();
$loginUserID = $result['userid']; //storing the result in my own variable

$view->DeliveryPointDataSet = $myDPDSObject->getUserParcel($loginUserID); //variable is parameter of this function. storing the results in variable

if (isset($_POST['Reject'])) { //if user rejects parcel

        $myUDSObject = new UsersDataSet();
        $parcelID = htmlentities($_POST['parcelID']);
        $myDPDSObject->cancelParcel( $parcelID ); //cancel the parcel
        $myUDSObject->increaseRejectionNo($loginUserID); //increase the rejection no by 1

}


if(isset($_POST['searchParcel'])){

    if (empty($_POST["searchingParameter"])) { //checking if field is empty
        $generalError = "Field can't be empty"; //display error message if yes
    }else {$myDPDSObject = new DeliveryPointDataSet();
        //search using the data given via the form
        $parameter=htmlentities($_POST['searchingParameter']);
        $searchResults = $myDPDSObject->searchParcel($loginUserID, $parameter); //send it through to the method
        $view->searchResults = $searchResults; //to view the result u get from the method
    }
}

require_once ('Views/deliverer.phtml');
