let passwordApprov = false;

$(document).ready(function () {
  if (window.location.search.includes("Unauthorized")) {
    notif("error", "Unauthorize access . Login first.");
  }
});

$("#Login").on("click", (event) => {
  const trigger = event.target.id;
  $("#SignUp").removeClass("bg-blue-500");
  $("#Login").addClass("bg-blue-500");
  $("#Component_Login").removeClass("hidden");
  $("#Component_Signup").addClass("hidden");
});

$("#SignUp").on("click", (event) => {
  const trigger = event.target.id;
  $("#Login").removeClass("bg-blue-500");
  $("#SignUp").addClass("bg-blue-500");
  $("#Component_Login").addClass("hidden");
  $("#Component_Signup").removeClass("hidden");
});
$("#login-form :checkbox ").on("change", function (e) {
  e.preventDefault();
  if (this.checked) {
    $("#KeepMeLogText").addClass("text-green-500");
  } else {
    $("#KeepMeLogText").removeClass("text-green-500");
  }
});
$("#signup-form :checkbox ").on("change", (event) => {
  event.preventDefault();
  if (event.target.checked) {
    $("#EmailNotification").addClass("text-green-500");
  } else {
    $("#EmailNotification").removeClass("text-green-500");
  }
});
$("#password").on("input", (event) => {
  event.preventDefault();

  if (
    event.target.value == $("#repeatPassword").val() &&
    event.target.value != ""
  ) {
    $("#" + event.target.id).addClass("border-green-500");
    $("#" + event.target.id).removeClass("border-red-500");
    $("#repeatPassword").addClass("border-green-500");
    $("#repeatPassword").removeClass("border-red-500");
  } else {
    $("#" + event.target.id).addClass("border-red-500");
    $("#" + event.target.id).removeClass("border-green-500");
    $("#repeatPassword").addClass("border-red-500");
    $("#repeatPassword").removeClass("border-green-500");
  }
  passwordApprov = passwordCheck(event.target.value);
});
$("#repeatPassword").on("input", (event) => {
  event.preventDefault();
  if (event.target.value == $("#password").val() && event.target.value != "") {
    $("#" + event.target.id).addClass("border-green-500");
    $("#" + event.target.id).removeClass("border-red-500");
    $("#password").addClass("border-green-500");
    $("#password").removeClass("border-red-500");
  } else {
    $("#" + event.target.id).addClass("border-red-500");
    $("#" + event.target.id).removeClass("border-green-500");
    $("#password").addClass("border-red-500");
    $("#password").removeClass("border-green-500");
  }
});

function passwordCheck(password) {
  var strongRegex = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
  let validPassword = false;
  let passwordContainsDigit = /\d/.test(password);
  let passwordContainsLowerCase = /[a-z]/.test(password);
  let passwordContainsUpperCase = /[A-Z]/.test(password);
  let passwordContainsSpecialChar = strongRegex.test(password);
  let passwordLegnth = password.length > 8;
  if (passwordLegnth) {
    $("#isLength").addClass("text-green-500");
    $("#isLength").removeClass("text-red-500");
  } else {
    $("#isLength").removeClass("text-green-500");
    $("#isLength").addClass("text-red-500");
  }
  if (passwordContainsDigit) {
    $("#isDigit").addClass("text-green-500");
    $("#isDigit").removeClass("text-red-500");
  } else {
    $("#isDigit").removeClass("text-green-500");
    $("#isDigit").addClass("text-red-500");
  }
  if (passwordContainsLowerCase) {
    $("#isLower").addClass("text-green-500");
    $("#isLower").removeClass("text-red-500");
  } else {
    $("#isLower").removeClass("text-green-500");
    $("#isLower").addClass("text-red-500");
  }
  if (passwordContainsSpecialChar) {
    $("#isSpecial").addClass("text-green-500");
    $("#isSpecial").removeClass("text-red-500");
  } else {
    $("#isSpecial").removeClass("text-green-500");
    $("#isSpecial").addClass("text-red-500");
  }
  if (passwordContainsUpperCase) {
    $("#isUpper").addClass("text-green-500");
    $("#isUpper").removeClass("text-red-500");
  } else {
    $("#isUpper").removeClass("text-green-500");
    $("#isUpper").addClass("text-red-500");
  }

  if (
    passwordContainsLowerCase === true &&
    passwordContainsUpperCase === true &&
    passwordContainsSpecialChar === true &&
    passwordContainsDigit === true &&
    passwordLegnth === true
  ) {
    validPassword = true;
  }
  return validPassword;
}

$("#signup-form").on("submit", (event) => {
  event.preventDefault();
  let data = $("#signup-form").serializeArray();

  let username = data[0].value == "";
  let password = data[1].value == "";
  let repeatPassword = data[2].value == "";
  let storename = data[3].value == "";
  let email = data[4].value == "";
  console.log(data);
  if (
    !username &&
    !password &&
    !repeatPassword &&
    !storename &&
    !email &&
    passwordApprov
  ) {
    $.ajax({
      type: "post",
      url: "/configs/php/signup_script.php",
      data: data,
      success: function (response) {
        const response_obj = response_handler(response);
        console.log(response);
        if (response_obj.code == "404") {
          notif(
            "error",
            "Error " + response_obj.code + " : " + response_obj.message
          );
        } else if (response_obj.code == 411) {
          notif(
            "error",
            "Error " + response_obj.code + " : " + response_obj.message
          );
        } else if (response_obj.code == 1062) {
          notif(
            "error",
            "Error " + response_obj.code + " : " + response_obj.message
          );
        } else if (response_obj.code == 200) {
          notif("accept", response_obj.message);
        } else {
          notif(
            "error",
            "Error 500: Internal Server error. Please try again later."
          );
        }
      },
    });
  }
  if (username) {
    notif("error", "Username is required");
  }
  if (password) {
    notif("error", "Password is required");
  }
  if (repeatPassword) {
    notif("error", "Repeat Password is required");
  }
  if (storename) {
    notif("error", "Store Name is required");
  }
  if (email) {
    notif("error", "Email is required");
  }
});

$("#login-form").on("submit", (event) => {
  event.preventDefault();
  let data = $("#" + event.target.id).serializeArray();

  if (data[0].value == "") {
    notif("warning", "Login username feild is empty.");
  } else if (data[1].value == "") {
    notif("warning", "Login password feild is empty.");
  } else {
    $.ajax({
      type: "post",
      url: "/configs/php/login_script.php",
      data: data,
      success: function (response) {
        let obj = response_handler(response);
        if (obj.code == 200) {
          notif("accept", obj.message);
          document.cookie = obj.token;
          open("/cashier_panel.php", "_self");
        } else if (obj.code == 401) {
          notif("error", obj.message);
        }
      },
    });
  }
});
