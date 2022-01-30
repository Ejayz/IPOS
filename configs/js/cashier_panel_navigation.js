$(document).ready(function () {
  $(".nav-name").addClass("hidden");
  $(".button-menu").removeClass("grid-cols-2");
  $(".button-menu").addClass("grid-cols-1");
  $("#menu-tag-icon").attr("src", "assets/images/open_menu.png");

});

$("#cashier-panel-nav").on("click", (event) => {
  event.preventDefault();
  let classList = $("#nav_panel")[0].className;
  let parentId = "nav_panel";
  if (classList.includes("w-2/12")) {
    $("#" + parentId).removeClass("w-2/12");
    $("#" + parentId).addClass("w-1/12");
    $(".nav-name").addClass("hidden");
    $(".button-menu").removeClass("grid-cols-2");
    $(".button-menu").addClass("grid-cols-1");
    $("#menu-tag-icon").attr("src", "assets/images/open_menu.png");
  } else {
    $("#" + parentId).removeClass("w-1/12");
    $("#" + parentId).addClass("w-2/12");
    $(".nav-name").removeClass("hidden");
    $(".button-menu").addClass("grid-cols-2");
    $(".button-menu").removeClass("grid-cols-1");
    $("#menu-tag-icon").attr("src", "assets/images/close_menu.png");
  }
});

$("#NewItem").on("click", (event) => {
  event.preventDefault();
  open("/new_item.php", "_self");
});

$("#Dashboard").on("click", (event) => {
  event.preventDefault();
  open("cashier_panel.php", "_self");
});

function logout() {
  $.ajax({
    type: "post",
    url: "/configs/php/logout_script.php",
    data: {},
    success: function (response) {
      if (response == 200) {
        open("/", "_self");
        notif("warning", "You are logged out of session.");
      } else {
        notif("error", "Something went wrong while logging out.");
      }
    },
  });
}
