<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/tailwind.css">
    <link rel="stylesheet" href="assets/font.css">
    <link rel="stylesheet" href="assets/background.css">
    <script src="/assets/jquery.js"></script>
    <title>Start-PoS</title>
</head>

<body id="#body">
    <div id="notification-banner-container" class="w-1/4 absolute right-0 h-screen overflow-y-hidden">
    </div>
    <div id="UI_Container" class="h-screen w-screen flex flex-row">
        <div id="Access_Container" class="w-5/12 grid h-screen">
            <div id="Menu" class="w-full h-full bg-gray-700 antialiased">
                <div class="w-3/4 h-12 mt-4 mr-auto ml-auto mb-4 gap-0 rounded-full bg-gradient-to-r from-purple-300 to-blue-300 grid grid-cols-2">
                    <div id="Login" class="items-center cursor-pointer grid w-full bg-blue-500 rounded-l-full">
                        <p id="LoginText" class="inline-block mr-auto ml-auto align-middle">Login</p>
                    </div>
                    <div id="SignUp" class="cursor-pointer items-center grid rounded-r-full">
                        <p id="SignUpText" class="inline-block mr-auto ml-auto align-middle">Signup</p>
                    </div>
                </div>
                <form id="login-form" class="w-full">
                    <div id="Component_Login" class="w-full items-center justify-items-center text-white grid">
                        <div class="w-full h-5/6 bg-gray-700 rounded-xl grid text-black">
                            <p class="font-sans text-3xl mr-auto ml-auto text-white  mt-4 mb-4">Login</p>
                            <input type="text" id="login-username" name="username" class="w-3/4 h-10 text-center focus:outline-none mb-2 mr-auto ml-auto mt-2 shadow-md" placeholder="Username" />
                            <input type="password" id="login-password" name="password" class="w-3/4 h-10 text-center focus:outline-none mb-2 mr-auto ml-auto mt-2 shadow-md" placeholder="Password" />
                            <div class="h-12 mr-auto ml-auto w-full text-white flex items-center justify-center font-sans font-medium">
                                <input id="KeepMeLog" id="login-remember" name="remember" class="w-6 h-6" type="checkbox" />
                                <label for="keepMeLog" class="h-12 items-center flex">
                                    <span id="KeepMeLogText" class="ml-2">Click to keep you login</span>
                                </label>
                            </div>
                            <input type="submit" value="Login" class="w-3/4 h-12 mx-auto rounded-full shadow-2xl" />
                        </div>
                    </div>
                </form>
                <form id="signup-form">
                    <div id="Component_Signup" class="w-full mr-auto ml-auto items-center hidden justify-items-center text-white grid h-1/2">
                        <div class="w-full h-full bg-gray-700 rounded-xl grid text-black">
                            <p class="font-sans text-white text-4xl mr-auto ml-auto mt-4 mb-4">Sign Up</p>
                            <input name="username" id="username" type="text" class="w-3/4 h-10 text-center focus:outline-none mb-2 mr-auto ml-auto mt-2 shadow-md" placeholder="Username" />
                            <input name="password" id="password" type="password" class="w-3/4 h-10 text-center border-red-500 border-2 focus:outline-none mb-2 mr-auto ml-auto mt-2 shadow-md" placeholder="Password" />
                            <div class="w-auto text-center">
                                <p id="isLength" class="text-red-500">8 characters and </p>
                                <p id="isSpecial" class="text-red-500">Contains Special Character </p>
                                <p id="isDigit" class="text-red-500"> Contains Digit </p>
                                <p id="isLower" class="text-red-500">Contains Lowecase Character</p>
                                <p id="isUpper" class="text-red-500">Contains Uppercase Character</p>
                            </div>
                            <input name="repeatPassword" id="repeatPassword" type="password" class="w-3/4 h-10 text-center border-2 border-red-500 focus:outline-none mb-2 mr-auto ml-auto mt-2 shadow-md" placeholder="Repeat Password" />
                            <input name="email" id="email" type="email" class="w-3/4 h-10 text-center border-2  focus:outline-none mb-2 mr-auto ml-auto mt-2 shadow-md" placeholder="Email" />
                            <input name="storename" id="storename" type="text" class="w-3/4 h-10 text-center focus:outline-none mb-2 mr-auto ml-auto mt-2 shadow-md" placeholder="Store Name" />
                            <div class="h-6 w-full text-white flex items-center justify-center font-sans font-medium">
                                <input name="emailnotification" id=" emailNotification" class="w-4 h-4" type="checkbox" name="EmailNotification" />
                                <label for="emailNotification" class="h-12 items-center flex ">
                                    <span id="EmailNotification" class="ml-2 ">Subscribe to email notifications</span>
                                </label>
                            </div>
                            <p class="text-green-500 mr-auto ml-auto mt-2 mb-2">
                                By signing up you agree to our terms and condition.
                            </p>
                            <input type="submit" value="Sign Up" class="w-3/4 h-12 mx-auto rounded-full shadow-md" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="Title_Container" class="bg-image-landing flex items-center w-7/12 justify-center h-screen">
            <div class="flex flex-col bg-white p-4 rounded-md flex-nowrap">
                <div class=" ">
                    <p class="text-4xl stroke-red-500 font-bold bg-clip-text gradient-text-clip antialiased">
                        Edge Digital Marketing Services
                    </p>
                </div>
                <div class="flex items-center">
                    <img class="w-28 h-28 border-r-8 border-black pr-2" src="/assets/images/pos_logo.png" />
                    <span class="text-3xl bg-white p-2 rounded-tr-md rounded-br-md">Interconnected Point Of Sales</span>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/configs/js//response_handler.js"></script>
<script src="/configs/js/account_menu_state.js"></script>
<script src="/configs/js/notification_banner.js"></script>


</html>