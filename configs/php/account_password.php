<?php
session_start();
include 'database.php';

if (!isset($_POST["password"])) {
    echo "402:Bad request,Information required is missing . Please try again .";
    return 0;
}

$token = $_POST["token"];
if ($_SESSION["token"] != $token) {
    echo 403;
    return 0;
}


$password = $connect->real_escape_string($_POST["password"]);
$user_id = $_SESSION["user_id"];
$sql = "select * from accounts where USER_ID=? and IS_EXIST='true';";
$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["PASSWORD"])) {
        echo "200";
    } else {
        echo "401";
    }
} else {
    echo "401";
}
