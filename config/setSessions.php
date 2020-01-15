<?php

    session_start();
    //################ Membres ################
if (!isset($_SESSION["signin"])) {
    $_SESSION["signin"]="";
}
if (!isset($_SESSION["signup"])) {
    $_SESSION["signup"]="";
}
if (!isset($_SESSION["firstname"])) {
    $_SESSION["firstname"]="Enter Firstname:";
}
if (!isset($_SESSION["lastname"])) {
    $_SESSION["lastname"]="Enter Lastname:";
}
if (!isset($_SESSION["pseudo"])) {
    $_SESSION["pseudo"]="Enter Pseudo:";
}
if (!isset($_SESSION["birthday"])) {
    $_SESSION["birthday"]="Enter Birthday:";
}
if (!isset($_SESSION["email"])) {
    $_SESSION["email"]="Enter Email:";
}
if (!isset($_SESSION["password"])) {
    $_SESSION["password"]="Enter Password:";
}
if (!isset($_SESSION["authority"])) {
    $_SESSION["authority"]="R";
}
if (!isset($_SESSION["userId"])) {
    $_SESSION["userId"]="";
}
if (!isset($_SESSION["error"])) {
    $_SESSION["error"]="";
}


    //################ Admin ################

if (!isset($_SESSION["action_name"])) {
    $_SESSION["action_name"]="Enter Your Action";
}
if (!isset($_SESSION["action_zipcode"])) {
    $_SESSION["action_zipcode"]="Type your Zipcode";
}
if (!isset($_SESSION["action_street"])) {
    $_SESSION["action_street"]="Typ the place of the Action";
}
if (!isset($_SESSION["action_event"])) {
    $_SESSION["action_event"]="Explaine your action!";
}
