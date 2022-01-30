let item_id;
let identifier_data;
$("#quantity-frame-ok-button").on("click", (event) => {
  event.preventDefault();
  quantity = $("#item_quantity").val();
  $.ajax({
    type: "post",
    url: "/configs/php/cart_item.php",
    data: {
      item_id: item_id,
      item_quantity: quantity,
    },
    success: function (response) {
      let handler = response_handler(response);
      if (handler.code == 402) {
        notif("error", handler.message);
      } else {
        $("#purchase_data").append(response);
        $("#search").val("").trigger("input");
        $("#search").focus();
        $("#item-quantity-frame").addClass("hidden");
        $("seach-container").addClass("z-10");
      }
    },
  });
});

function data(data) {
  item_id = data;
  $("#item-quantity-frame").removeClass("hidden");
  $("#item_quantity").focus();
}

function removeItem(identifier) {
  $("#password-confirm-frame").removeClass("hidden");
  identifier_data = identifier;
}

$("#account-frame-ok-button").on("click", (event) => {
  event.preventDefault();
  let account = $("#account-password").val();
  let token = $("#token").val();
  $.ajax({
    type: "post",
    url: "/configs/php/account_password.php",
    data: {
      password: account,
      token: token,
    },
    success: function (response) {
      console.log(response);
      if (response == 200) {
        $("#password-confirm-frame").addClass("hidden");
        $("#" + identifier_data).remove();
      } else if (response == 401) {
        notif(
          "warning",
          "Removing this item is restricted ,You provided wrong password"
        );
      } else if (response == 403) {
        notif("error", "Invalid token ,Please relogin or refresh this page.");
      }
    },
  });
});

$("#quantity-frame-cancel-button").on("click", (event) => {
  event.preventDefault();
  $("#item-quantity-frame").addClass("hidden");
});

$("#account-frame-cancel-button").on("click", (event) => {
  event.preventDefault();
  $("#password-confirm-frame").addClass("hidden");
});
