<?php
//to record transactions 1 x 1

require 'database.php';
require 'general_function.php';
session_start();

$user_id = $_SESSION["user_id"];
$item_id = idStripper($connect->real_escape_string($_POST["item_id"]));
$item_quantity = $connect->real_escape_string($_POST["item_quantity"]);
$item_description = $connect->real_escape_string($_POST["item_description"]);
$item_price = $connect->real_escape_string($_POST["item_price"]);
$transaction_id = $connect->real_escape_string($_POST["transaction_id"]);
$transaction_date = $connect->real_escape_string($_POST["transaction_date"]);
$token_natural = $connect->real_escape_string($_POST['token']);
try {

    if (jwt_verify($token_natural)) {
        $sql = "INSERT INTO `pointofsales`.`transactions` (`USER_ID`,`TRANSACTION_ID`, `ITEM_ID`, `ITEM_QUANTITY`, `ITEM_DESCRIPTION`, `ITEM_PRICE`, `TRANSACTION_DATE`, `IS_TRANSACTION_EXIST`) VALUES (?,?,?,?,?,?,?,'true');";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sssisds", $user_id, $transaction_id, $item_id, $item_quantity, $item_description, $item_price, $transaction_date);
        $result = $stmt->execute();
        if ($result) {
            echo 200;
        }
    }
} catch (Exception $e) {
    echo $e;
}
