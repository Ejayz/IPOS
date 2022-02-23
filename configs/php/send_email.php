<?php

require "../..//mail_handler.php";
require "database.php";

$transaction_id = $_POST["transaction_id"];
$store_name = $_POST["store_name"];
$email = $_POST["email"];
$table_data = $_POST["table_data"];
$amount_due = $_POST["amount_due"];
$change = $_POST["change"];
$total_quantity = $_POST["total_quantity"];
$cash = $_POST["cash"];
echo send_Reciept($connect, $table_data, $store_name, $email, $transaction_id, $amount_due, $total_quantity, $cash, $change);
