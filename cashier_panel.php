<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location:/index.php?err=Unauthorized");
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/tailwind.css">
    <link rel="stylesheet" href="assets/font.css">
    <link rel="stylesheet" href="assets/background.css">
    <link rel="stylesheet" href="assets/table.css">
    <link rel="stylesheet" href="assets/print.min.css">
    <script type="module" src="node_modules/prntr/dist/prntr.esm.js"></script>
    <script src="/assets/jquery.js"></script>
    <script src="/assets/quagga.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.js" integrity="sha512-/fgTphwXa3lqAhN+I8gG8AvuaTErm1YxpUjbdCvwfTMyv8UZnFyId7ft5736xQ6CyQN4Nzr21lBuWWA9RTCXCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Cashier Panel-PoS</title>
</head>

<body id="#body">
    <span type="text" id="link" hidden></span>
    <div id="notification-banner-container" class="w-1/4 hidden z-50 absolute right-0 h-screen overflow-y-hidden">
    </div>
    <div id="item-quantity-frame" class="w-full hidden h-full grid bg-white bg-opacity-40 z-40 absolute">
        <div class="w-1/2 bg-gray-300 text-center grid h-32 mr-auto ml-auto mt-auto mb-auto">
            <p>Enter item quantity</p>
            <input id="item_quantity" type="number" placeholder="Quantity" class="focus:outline-none mr-auto ml-auto mt-2 w-3/4 h-8">
            <div class="w-full h-12 grid text-center grid-cols-2">
                <button id="quantity-frame-ok-button" class="focus:outline-none hover:bg-blue-400 w-1/3 mr-auto ml-auto border-2 bg-red-400">OK</button>
                <button id="quantity-frame-cancel-button" class="focus:outline-none hover:bg-blue-400 w-1/3 mr-auto ml-auto border-2 bg-gray-400">Cancel</button>
            </div>
        </div>
    </div>
    <div id="password-confirm-frame" class="w-full hidden h-full grid bg-white bg-opacity-40 z-40 absolute">
        <div class="w-1/2 bg-gray-300 text-center grid h-32 mr-auto ml-auto mt-auto mb-auto">
            <p>Enter password to proceed removing this item</p>
            <input id="token" value="<?php echo $_COOKIE["token"]; ?>" hidden>
            <input id="account-password" type="password" placeholder="Password" class="focus:outline-none mr-auto ml-auto mt-2 w-3/4 h-8">
            <div class="w-full h-12 grid text-center grid-cols-2">
                <button id="account-frame-ok-button" class="focus:outline-none hover:bg-blue-400 w-1/3 mr-auto ml-auto border-2 bg-red-400">Continue</button>
                <button id="account-frame-cancel-button" class="focus:outline-none hover:bg-blue-400 w-1/3 mr-auto ml-auto border-2 bg-gray-400">Cancel</button>
            </div>
        </div>
    </div>
    <div id="cash-confirm-frame" class="w-full hidden  h-full grid bg-white bg-opacity-40 z-40 absolute">
        <div class="w-1/2 bg-gray-300 text-center grid h-32 mr-auto ml-auto mt-auto mb-auto">
            <p>Enter cash amount</p>
            <input id="cash_input" type="number" step="any" placeholder="Enter Cash" class="focus:outline-none mr-auto ml-auto mt-2 w-3/4 h-8">
            <div class="w-full h-12 grid text-center grid-cols-2">
                <button id="cash-frame-ok-button" class="focus:outline-none hover:bg-blue-400 w-1/3 mr-auto ml-auto border-2 bg-red-400">Continue</button>
                <button id="cash-frame-cancel-button" class="focus:outline-none hover:bg-blue-400 w-1/3 mr-auto ml-auto border-2 bg-gray-400">Cancel</button>
            </div>
        </div>
    </div>

    <div class="w-screen h-screen flex">
        <div id="nav_panel" class=" bg-gray-800 text-white w-1/12 text-sm flex flex-col">
            <div id="cashier-panel-nav" class="h-16  cursor-pointer button-menu w-full grid hover:bg-blue-300 grid-cols-2">
                <span id="nav-panel-name" class="nav-name mr-auto ml-auto mb-auto mt-auto">Menu</span>
                <img id="menu-tag-icon" src="assets/images/close_menu.png" class="w-12 ml-auto mr-auto mt-auto mb-auto h-12" />
            </div>
            <div id="Dashboard" class="cashier-panel-nav button-menu marker:h-16 cursor-pointer w-full  grid grid-cols-2">
                <span class="nav-name mr-auto ml-auto mb-auto text-center  mt-auto">Dashboard</span>
                <img src="assets/images/dashboard-icon.png" class=" w-12 ml-auto mr-auto mt-auto mb-auto h-12" />
            </div>
            <div id="NewItem" class="h-16 cursor-pointer w-full grid hover:bg-blue-300 grid-cols-2 button-menu">
                <span id="nav-panel-name" class="nav-name mr-auto ml-auto mt-auto mb-auto">New Item</span>
                <img src="assets/images/new_item.png" class="w-12 ml-auto mr-auto mt-auto mb-auto h-12" />
            </div>
            <div id="EditItem" class="h-16 cursor-pointer w-full grid hover:bg-blue-300 grid-cols-2 button-menu">
                <span id="nav-panel-name" class="nav-name mr-auto ml-auto mt-auto mb-auto">Edit Item</span>
                <img src="assets/images/edit_item.png" class="w-12 ml-auto mr-auto mt-4 h-12" />
            </div>
            <div id="Settings" class="h-16 cursor-pointer w-full grid hover:bg-blue-300 grid-cols-2 button-menu">
                <span id="nav-panel-name" class="nav-name mr-auto ml-auto mt-auto mb-auto">Settings</span>
                <img src="assets/images/setting.png" class="w-12 ml-auto mr-auto mt-auto mb-auto h-12" />
            </div>
            <div onclick="logout();" class="h-16 cursor-pointer w-full grid hover:bg-blue-300 grid-cols-2 button-menu">
                <span id="nav-panel-name" class="nav-name mr-auto ml-auto mt-auto mb-auto">Logout</span>
                <img src="assets/images/logout_user.png" class="w-12 ml-auto mr-auto mt-auto mb-auto h-12" />
            </div>

        </div>
        <div class="bg-gray-500 w-full text-black flex flex-col">
            <div class="w-full items-center h-24 flex flex-row">
                <div id="search-container" class="w-3/4  h-64  ml-2 relative mt-4 flex flex-col mb-auto">
                    <input type="text" id="search" placeholder="Product search..." class="focus:outline-none w-3/4 static h-12 ml-2" />
                    <div id="search_result" class="overflow-x-hidden hidden z-30 overflow-y-auto  ml-2 no-scrollbar bg-white border-2 w-8/12 shadow-2xl flex flex-col">
                    </div>
                </div>
                <div class="w-36 z-30 h-auto items-center">
                    <select id="camera-list" class="w-36 focus:outline-none text-black h-12 float-right mr-4 ml-2">
                        <option selected disabled hidden value="">Camera List</option>
                    </select>

                </div>
                <div class="w-64 mt-64 h-64">
                    <div class="w-64 mr-auto ml-auto transform scale-75 h-64">
                        <div id="interactive" class="border-2 w-64 h-64 border-solid  viewport scanner">
                            <video id="video_feed" class="w-64 h-64" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full  h-full z-20 overflow-hidden  flex flex-row">
                <div id="table_container" class="w-3/4 h-11/12 bg-red-300 overflow-x-hidden overflow-y-scroll">
                    <table id="purchase_data" class="w-full table-auto  h-auto">
                        <tr class="purchase_data_header h-6">
                            <th class="text-center">QTY</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Amount</th>
                            <th class="item_action text-center">Action</th>
                        </tr>
                    </table>
                </div>
                <div class="w-1/4 h-full ">
                    <div class="mt-48">
                        <div class="w-full text-xl text-white">
                            <span class="ml-2">Amount Due:</span><span id="total_item" class="cart_info"></span>
                        </div>
                        <div class="w-full text-xl text-white">
                            <span class="ml-2">Total Quantity:</span><span id="total_quantity" class="cart_info"></span>
                        </div>
                        <hr>
                        <div class="w-full text-xl text-white">
                            <span class="ml-2">Cash:</span><span id="cash" class="cart_info"></span>
                        </div>
                        <div class="w-full text-xl text-white">
                            <span class="ml-2">Change:</span><span id="change" class="cart_info"></span>
                        </div>
                        <div class="w-full grid grid-cols-2 mt-4">
                            <button id="btn-process" class="bg-red-400 w-3/4 h-12 mr-auto ml-auto hover:bg-blue-500 focus:outline-none cursor-pointer">Process</button>
                            <button class="bg-red-400 w-3/4 h-12 mr-auto ml-auto focus:outline-none cursor-pointer">Cancel</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
<script src="/configs/js/response_handler.js"></script>
<script src="/configs/js/cashier_panel_navigation.js"></script>
<script src="/configs/js/notification_banner.js"></script>
<script src="/configs/js/quagga_process.js"></script>
<script src="/configs/js/cashier_panel.js"></script>


</html>