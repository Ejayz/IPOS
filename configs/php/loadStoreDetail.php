<?php
include 'database.php';

session_start();
if (!isset($_SESSION["user_id"])) {
    "401:Session is invalid .Please reloggin.If error continue please contact support.";
    return 0;
}
$sql = "select * from accounts where USER_ID=? AND IS_EXIST='true'";

$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $_SESSION["user_id"]);
$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "200:" . $row["STORE_NAME"];
} else {
    echo "401:Something went wrong .Please reloggin or if error persist contact support";
}
