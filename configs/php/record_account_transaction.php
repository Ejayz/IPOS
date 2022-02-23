<?php
include "database.php";
include "general_function.php";
session_start();


if (jwt_verify($_POST["token"])) {

    $transaction_id = $connect->real_escape_string($_POST["transaction_id"]);
    $amount_due = $connect->real_escape_string($_POST["amount_due"]);
    $change = $connect->real_escape_string($_POST["change"]);
    $total_cash = $connect->real_escape_string($_POST["total_cash"]);
    $total_item_quantity = $connect->real_escape_string($_POST["total_item_quantity"]);
    $is_email = $connect->real_escape_string($_POST["is_email"]);
    $email = $connect->real_escape_string($_POST["email"]);

    $sql = "INSERT INTO `pointofsales`.`account_transaction` (`TRANSACTION_ID`, `ACCOUNT_ID`, `AMOUNT_DUE`, `CHANGE`, `TOTAL_CASH`, `TOTAL_ITEM_QUANTITY`, `IS_EMAIL`, `EMAIL`, `IS_ACCOUNT_TRANSACTION_EXIST`) VALUES (?, ?, ?, ?,?, ?,?,?,'true');";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssdddiss", $transaction_id, $_SESSION["user_id"], $amount_due, $change, $total_cash, $total_item_quantity, $is_email, $email);
    $result = $stmt->execute();
    if ($result > 0) {
        echo 200;
    } else {
        echo 201;
    }
} else {
    echo 401;
}
