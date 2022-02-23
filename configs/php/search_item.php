<?php

include 'database.php';
session_start();

if (!isset($_POST["search"]) || !isset($_SESSION["user_id"])) {
    echo "400:Search request is invalid";
    return 0;
}


$keyword_org = $connect->real_escape_string($_POST["search"]);
$keyword = $connect->real_escape_string("%" . $_POST["search"] . "%");
$user_id = $_SESSION["user_id"];
$sql = "select ITEM_NAME,ITEM_ID,ITEM_PRICE from items_list where USER_ACCOUNT_ID=? AND ITEM_ID LIKE ? OR ITEM_DESCRIPTION LIKE ? OR ITEM_NAME LIKE ? ;";

$stmt = $connect->prepare($sql);
$stmt->bind_param("ssss", $user_id, $keyword, $keyword, $keyword);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 0) {
    while ($row = $result->fetch_assoc()) {
        echo  "<div onclick=\"SelectItem('" .
            $row["ITEM_ID"] .
            '\')" class="w-full h-12 results grid grid-cols-2 hover:bg-blue-500 ">' .
            '<p class=" w-full text-center  cursor-pointer">' .
            $row["ITEM_ID"] .
            "</p>" .
            '   <p class=" w-full  text-center  cursor-pointer">' .
            $row["ITEM_NAME"] .
            ", &#8369;" .
            $row["ITEM_PRICE"] .
            "</p>" .
            "</div>";
    }
} else {
    echo  '<p  class="results w-full text-center hover:bg-blue-500 cursor-pointer">' .
        "No data found related to '" . $keyword_org . "'" .
        "</p>";
}
