<!DOCTYPE html>
<html lang="en">
<?php
include 'configs/php/database.php';

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location:/index.php?err=Unauthorized");
}
$token = $_COOKIE["token"];
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/tailwind.css">
    <link rel="stylesheet" href="assets/font.css">
    <link rel="stylesheet" href="assets/background.css">
    <link rel="stylesheet" href="assets/table.css">
    <script src="/assets/jquery.js"></script>
    <script src="/assets/quagga.min.js"></script>

    <title>Cashier Panel-PoS</title>
</head>

<body id="#body">
    <div id="notification-banner-container" class="w-1/4 hidden z-50 absolute right-0 h-screen overflow-y-hidden">
    </div>
    <div class="w-screen h-screen flex">
        <div id="nav_panel" class=" bg-gray-800 text-white w-1/12 text-sm flex flex-col">

            <div id="cashier-panel-nav" class="h-16 cursor-pointer button-menu w-full grid hover:bg-blue-300 grid-cols-2">
                <span id="nav-panel-name" class="nav-name mr-auto ml-auto mb-auto mt-auto">Menu</span>
                <img id="menu-tag-icon" src="assets/images/close_menu.png" class="w-12 ml-auto mr-auto mt-auto mb-auto h-12" />
            </div>
            <div id="Dashboard" class="cashier-panel-nav button-menu marker:h-16 cursor-pointer w-full  grid grid-cols-2">
                <span class="nav-name mr-auto ml-auto mb-auto text-center  mt-auto">Cashier Dashboard</span>
                <img src="assets/images/dashboard-icon.png" class=" w-12 ml-auto mr-auto mt-auto mb-auto h-12" />
            </div>
            <div class="h-16 cursor-pointer w-full grid hover:bg-blue-300 grid-cols-2 button-menu">
                <span id="nav-panel-name" class="nav-name mr-auto ml-auto mt-auto mb-auto">New Item</span>
                <img src="assets/images/new_item.png" class="w-12 ml-auto mr-auto mt-auto mb-auto h-12" />
            </div>
            <div class="h-16 cursor-pointer w-full grid hover:bg-blue-300 grid-cols-2 button-menu">
                <span id="nav-panel-name" class="nav-name mr-auto ml-auto mt-auto mb-auto">Edit Item</span>
                <img src="assets/images/edit_item.png" class="w-12 ml-auto mr-auto mt-4 h-12" />
            </div>
            <div class="h-16 cursor-pointer w-full grid hover:bg-blue-300 grid-cols-2 button-menu">
                <span id="nav-panel-name" class="nav-name mr-auto ml-auto mt-auto mb-auto">Settings</span>
                <img src="assets/images/setting.png" class="w-12 ml-auto mr-auto mt-auto mb-auto h-12" />
            </div>
            <div onclick="logout();" class="h-16 cursor-pointer w-full grid hover:bg-blue-300 grid-cols-2 button-menu">
                <span id="nav-panel-name" class="nav-name mr-auto ml-auto mt-auto mb-auto">Logout</span>
                <img src="assets/images/logout_user.png" class="w-12 ml-auto mr-auto mt-auto mb-auto h-12" />
            </div>

        </div>
        <div class="bg-gray-500 w-full text-black flex flex-col">
            <div class="flex flex-row w-full ">
                <div class="w-3/4">
                    <form id="newItem" class="ml-2">
                        <fieldset class="w-11/12 border-2 grid border-white">
                            <legend class="text-center text-xl">New Item Form</legend>
                            <input name="token" type="text" class="w-3/4 mr-auto ml-auto text-center focus:outline-none h-8 mt-2 mb-2" hidden value="<?php echo $token; ?>" placeholder="">
                            <input name="item_id" id="item_id" type="text" class="w-3/4 mr-auto ml-auto text-center focus:outline-none h-8 mt-2 mb-2" placeholder="Item Tag">
                            <input name="item_name" id="item_name" type="text" class="w-3/4 mr-auto ml-auto text-center focus:outline-none h-8 mt-2 mb-2" placeholder="Item Name">
                            <input name="item_price" id="item_price" type="number" step="any" class="w-3/4 mr-auto ml-auto text-center focus:outline-none h-8 mt-2 mb-2" placeholder="Item Price">
                            <div class="w-full flex flex-col">
                                <textarea maxlength="250" name="item_description" id="item_description" class="text-center focus:outline-none w-3/4 mr-auto ml-auto h-24 mt-2 mb-2" placeholder="Description"></textarea>
                                <p id="add_item_character_counter" class="text-white text-center">Characters:0/250</p>
                            </div>
                            <input type="submit" class="w-1/4 h-12 mr-auto ml-auto mt-2 mb-2" value="submit" value="Add Item">
                        </fieldset>
                    </form>
                </div>
                <div class="w-1/4 grid">
                    <select id="camera-list" class="w-36 z-50 mt-4 focus:outline-none text-black h-12 mr-auto ml-auto">
                        <option selected disabled hidden value="">Camera List</option>
                    </select>
                    <div class="w-64 mr-auto ml-auto transform scale-75 h-64">
                        <div id="interactive" class="border-2 w-64 h-64 border-solid  viewport scanner">
                            <video id="video_feed" class="w-64 h-64" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full mt-4 text-center">
                <table id="items_table" class="w-10/12 mr-auto ml-auto table-fixed">
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Item Description</th>
                        <th>Item Price</th>
                        <th>Date Added</th>s
                    </tr>

                    <?php
                    $sql = "select * from items_list where ITEM_EXIST='true' and USER_ACCOUNT_ID=?";
                    $stmt = $connect->prepare($sql);
                    $stmt->bind_param("s", $_SESSION["user_id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows == 0) {
                        echo " <tr class=\"item_rows \">
                        <td colspan='5'>There is no item that is added yet.</td>
                    </tr>";
                    } else {
                        while ($row = $result->fetch_assoc()) {
                            echo "
                            <tr class=\"item_rows \">
                            <td>" . $row["ITEM_ID"] . "</td>
                            <td>" . $row["ITEM_NAME"] . "</td>
                            <td>" . $row["ITEM_DESCRIPTION"] . "</td>
                            <td> &#8369; " . $row["ITEM_PRICE"] . "</td>
                            <td>" . $row["ITEM_ADDED_DATE"] . "</td>
                            </tr>
                            ";
                        }
                    }
                    ?>
                    <!-- <tr>
                        <td>Item ID</td>
                        <td>Item Name</td>
                        <td>Item Description</td>
                        <td>Item Price</td>
                        <td>Date Added</td>
                    </tr> -->

                </table>
            </div>
        </div>
    </div>
</body>
<script src="/configs/js/response_handler.js"></script>
<script src="/configs/js/cashier_panel_navigation.js"></script>
<script src="/configs/js/notification_banner.js"></script>
<script src="/configs/js/quagga_process.js"></script>
<script src="configs/js/new_item.js"></script>


</html>