<?php
function generateUid()
{
    $list = "abcdefghijkmnopqstuvwxyz1234567890";
    $uid = "";
    $split = str_split($list, 1);
    for ($i = 0; $i < 1; $i++) {
        for ($c = 0; $c < 64; $c++) {
            $ran = rand(0, 33);
            $uid = $uid . "" . $split[$ran];
        }
    }
    return $uid;
}

function returnDate()
{
    date_default_timezone_set('Asia/Manila');
    $date = new DateTime();
    $date = $date->format("d-m-Y H:i:s");
    return $date;
}

function jwt($randomString)
{
    $token = hash("sha256", $randomString);
    $_SESSION['token'] = $token;
    return $token;
}

function jwt_verify($token)
{
    if ($token == $_SESSION['token']) {
        return true;
    } else {
        return false;
    }
}

function checkDuplicateItem($connect, $userid, $productid)
{
    $sql = "select * from items_list where USER_ACCOUNT_ID=? AND ITEM_ID=? AND ITEM_EXIST='true'";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ss", $userid, $productid);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        return true;
    } else {
        return false;
    }
}


function getTotalPrice($quantity, $item_price)
{
    return $quantity * $item_price;
}

function idStripper($item_id)
{
    $data =  explode(":", $item_id);
    return $data[0];
}
