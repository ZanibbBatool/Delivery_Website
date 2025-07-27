<?php

require_once('Models/DeliveryPointDataSet.php');
require_once ('Models/DeliveryPointData.php');
//initializing error message variables
$recNameError=$add1Error=$add2Error=$pError=$dError=$latError=$lngError=$statError=$delError="";
$view = new stdClass();
$view->pageTitle = 'Parcel Information';

//fetching all the parcels to store in table
$deliveryPointDataSet = new DeliveryPointDataSet();
$view->DeliveryPointDataSet = $deliveryPointDataSet->fetchAllDeliveryPoint();



//if create parcel is set then check for validation then create deliv point obj
if(isset($_POST['CreateParcel']) ){
    if (empty($_POST['recipientName'])) {
        $recNameError = "Name is required";
    }
    elseif(empty($_POST['address1'])){
        $add1Error=" Address is required";
    }
    elseif(empty($_POST['address2'])){
        $add2Error="Address is required";
    }
    if (empty($_POST['postcode'])) {
        $pError = "Postcode is required";
    }
    elseif(empty($_POST['deliverer'])){
        $dError=" deliverer is required";
    }
    elseif(empty($_POST['latitude'])){
        $latError="latitude type is required";
    }
    elseif(empty($_POST['longitude'])){
        $lngError="longitude is required";
    }
    elseif(empty($_POST['status'])){
        $statError="Status is required";
    }
    else{
    $myDPDSObject = new DeliveryPointDataSet();
    $name = htmlentities($_POST['recipientName']);
    $address_1= htmlentities($_POST['address1']);
    $address_2 = htmlentities($_POST['address2']);
    $postcode = htmlentities($_POST['postcode']);
    $deliverer = htmlentities($_POST['deliverer']);
    $lat = htmlentities($_POST['latitude']);
    $lng = htmlentities($_POST['longitude']);
    $status = htmlentities($_POST['status']);
    $del_photo = htmlentities($_POST['delPhoto']);
    //call on create parcel methods and pass the stored variables as parameters
    $myDPDSObject->createParcel($name, $address_1, $address_2, $postcode,$deliverer, $lat, $lng, $status, $del_photo);
}}

if(isset($_POST['DeleteParcel'])){//if delete parcel is set,then check if field is empty first
    if(empty($_POST['parcelID'])){
        $delError="insert parcel ID";
    }
    $myDPDSObject = new DeliveryPointDataSet();
    $id=htmlentities($_POST['parcelID']);
    $myDPDSObject->deleteParcel($id); //then pass parcel id to delete method
}
//if change deliverer is set then try calling the method
if(isset($_POST['ChangeDeliverer'])){

        $myDPDSObject = new DeliveryPointDataSet();
        $delivererID = htmlentities($_POST['delivererID']);
        $newDelivererID = htmlentities($_POST['newDelivererID']);
        $myDPDSObject->changeDeliverer($delivererID, $newDelivererID);

}
//if change address is pressed then call the function and pass the variables
if(isset($_POST['ChangeAddress'])){
        $myDPDSObject = new DeliveryPointDataSet();
        $oldAddress1 = htmlentities($_POST['oldAddress1']);
        $newAddress1 = htmlentities($_POST['newAddress1']);

        $oldAddress2 = htmlentities($_POST['oldAddress2']);
        $newAddress2 = htmlentities($_POST['newAddress2']);

        $oldLatitude = htmlentities($_POST['oldLatitude']);
        $newLatitude = htmlentities($_POST['newLatitude']);

        $oldLongitude = htmlentities($_POST['oldLongitude']);
        $newLongitude = htmlentities($_POST['newLongitude']);

        $oldPostcode = htmlentities($_POST['oldPostcode']);
        $newPostcode = htmlentities($_POST['newPostcode']);

        $oldDeliveryPhoto = htmlentities($_POST['oldDeliveryPhoto']);
        $newDeliveryPhoto = htmlentities($_POST['newDeliveryPhoto']);

        $myDPDSObject->changeAddress(
            $oldAddress1, $newAddress1,
            $oldAddress2, $newAddress2,
            $oldLatitude, $newLatitude,
            $oldLongitude, $newLongitude,
            $oldPostcode, $newPostcode,
            $oldDeliveryPhoto, $newDeliveryPhoto
        );

}

require_once('Views/parcel.phtml');