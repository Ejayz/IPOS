<?php
require 'database.php';
require 'general_function.php';
session_start();

$randomString = generateUid();
$token = jwt($randomString);

if (!isset($_POST["username"]) || !isset($_POST["password"])) {
    echo "404:Some data is missing while processing your sign up. Please review each field or contact support for further assistant.";
    return 0;
}

$username = $connect->real_escape_string($_POST['username']);
$password = $connect->real_escape_string($_POST['password']);
if (isset($_POST['remember'])) {
    $remember = true;
} else {
    $remember = false;
}

$sql = "SELECT * FROM accounts WHERE USERNAME=?  AND IS_EXIST='true'";
$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
    $data = $result->fetch_assoc();
    if (password_verify($password, $data["PASSWORD"])) {
        $_SESSION["user_id"]=$data["USER_ID"];
        if ($remember) {
            echo "200:Welcome " . $data["USERNAME"] . ":" . "token=" . $token . ";samesite=lax;expires=3600000*24*14;path=/";
        } else {
            echo "200:Welcome " . $data["USERNAME"] . ":" . "token=" . $token . ";samesite=lax;path=/";
        }
    } else {
        echo "401:Invalid access.Wrong username or password.";
    }
} else {
    echo "401:Invalid access.Wrong username or password.";
}
