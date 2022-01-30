<?php

require "./database.php";
require './general_function.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);



date_default_timezone_set('Asia/Manila');
if (isset($_POST["emailnotification"])) {
    $emailnotification = "false";
} else {
    $emailnotification = "true";
}
if (!(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['repeatPassword']) && isset($_POST['email']) && isset($_POST['storename']))) {
    echo "411:Required data is missing... Please review each field or contact support for further assistant.";
    return 0;
}
$password = $connect->real_escape_string($_POST["password"]);
$repeatPassword = $connect->real_escape_string($_POST["repeatPassword"]);

$username = $connect->real_escape_string($_POST["username"]);
$email = $connect->real_escape_string($_POST['email']);
$storename = $connect->real_escape_string($_POST['storename']);
$date = new DateTime();
$date = $date->format("d-m-Y H:i:s");
$uid = generateUid();


if ($password !== $repeatPassword) {
    echo "409:Password seems not the same to repeated password. Please try again or contact support.";
    return 0;
}

$password = $connect->real_escape_string(password_hash($_POST["password"], PASSWORD_DEFAULT, array("cost" => 9)));
$repeatPassword = $connect->real_escape_string(password_hash($_POST["repeatPassword"], PASSWORD_DEFAULT, array("cost" => 9)));

if ($username == "" && $password == "" &&  $repeatPassword == "" &&  $email == "" && $storename == "") {
    echo "404:Some data is missing while processing your sign up. Please review each field or contact support for further assistant.";
    return 0;
}
$sql = "INSERT INTO accounts (`USER_ID`, `USERNAME`, `PASSWORD`, `ACCOUNT_SUBSCRIPTION`, `SUBSCRIPTION_DATE`, `ACCOUNT_CREATION_DATE`, `STORE_NAME`, `EMAIL`, `IS_EMAIL_NOTIFICATION`, `IS_EXIST`) VALUES (?,?,?,0 ,?,?,?,?,?,'true');";
try {
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssssssss", $uid, $username, $password, $date, $date, $storename, $email, $emailnotification);
    $result = $stmt->execute();


    if ($result <= 1) {
        echo "200:Account creation was successfull.You can now login .";
    } else {
        echo "500:Internal Server Error. Something went wrong . Please try again or contact support for further assistant";
    }
} catch (Exception $e) {
    if ($e->getCode() == 1062) {
        echo "1062:Duplicate data.Email or username is already in use.";
    }
}
