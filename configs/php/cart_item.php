<?php
include 'database.php';
include 'general_function.php';


session_start();
if (!isset($_POST["item_id"]) || !isset($_POST["item_quantity"])) {
    echo "402:Bad request,Information required is missing . Please try again .";
    return 0;
}


$item_id = $connect->real_escape_string($_POST["item_id"]);
$item_quantity = $connect->real_escape_string($_POST["item_quantity"]);
$user_id = $_SESSION["user_id"];

if ($item_quantity == "") {
    echo "402:Bad request, Information required is missing.Please try again";
    return 0;
}

$sql = "select * from items_list where ITEM_ID=? AND USER_ACCOUNT_ID=? AND ITEM_EXIST='true'";
$stmt = $connect->prepare($sql);
$stmt->bind_param("ss", $item_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 0) {
    $row = $result->fetch_assoc();
    $identifier = $row["ITEM_ID"] . ':' . generateUid();
    $price = getTotalPrice($item_quantity, $row["ITEM_PRICE"]);
    echo '<tr id="' .  $identifier . '" class="items_data border-2 h-6">' .
        '<td class="item_quantity text-center">' . $item_quantity . '</td>' .
        '<td class="item_description text-center">' . $row["ITEM_NAME"] . " " . $row["ITEM_DESCRIPTION"] . '</td>' .
        '<td class="item_price text-center">&#8369; ' . $price . '</td>' .
        '<td class="item_action text-center"><span onclick="removeItem(\'' . $identifier . '\')" class="hover:bg-blue-500 cursor-pointer">Remove</span>|<span onclick="editQuantity(\'' . $identifier . '\')" class="hover:bg-blue-500 cursor-pointer">Edit Quantity</span></td> ' .
        '</tr>';
}
