<?php

include "general_function.php";
include "database.php";

session_start();
if (!isset($_POST["token"])) {
    echo "401:Authentication failed. Are you a robot?";
    return 0;
}
if (!jwt_verify($_POST["token"])) {
    echo "401:Authentication failed. Are you a robot?";
    return 0;
}


if (!isset($_POST["item_id"]) || !isset($_POST["item_name"]) || !isset($_POST["item_price"]) || !isset($_POST["item_description"])) {
    echo "400:Bad request";
    return 0;
}

$item_id = $connect->real_escape_string($_POST["item_id"]);
$item_name = $connect->real_escape_string($_POST["item_name"]);
$item_price = $connect->real_escape_string($_POST["item_price"]);
$item_description = $connect->real_escape_string($_POST["item_description"]);
$item_date = $connect->real_escape_string(returnDate());
$userid = $_SESSION["user_id"];


if (checkDuplicateItem($connect, $userid, $item_id)) {
    $sql = "INSERT INTO `pointofsales`.`items_list` (`ITEM_ID`, `ITEM_NAME`, `ITEM_DESCRIPTION`, `USER_ACCOUNT_ID`, `ITEM_PRICE`, `ITEM_ADDED_DATE`, `ITEM_EXIST`) VALUES (?,?,?,?,?,?,'true');";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssssds", $item_id, $item_name, $item_description, $userid, $item_price, $item_date);
    $stmt->execute();
    if ($stmt->affected_rows == 1) {
        echo "200:New item was added to the system.:" . "token=" . $token . ";samesite=lax;expires=3600000*24*14;path=/";
        jwt(generateUid());
    } else {
        echo "500:Internal Server error . Something went wrong while adding the item . Please try again later.";
    }
} else {
    echo "409:Item is already added to the system.";
}
