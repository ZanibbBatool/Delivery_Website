<?php

if (isset($_POST['Logout'])) { //if user presses logout, destory session
    session_unset();
    session_destroy();
    header('Location:index.php'); //redirect them to login page
}
require_once ('Views/manager.phtml');