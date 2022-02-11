let item_id;
let identifier_data;
let total_item;
let quantity;
let itemQuantity = 0;
let itemAmountDue = 0;
let itemChange = 0;
let storeName = "";
let date = "";
let transactionID = "";
let transactionDate = "";
let TotalCash = 0;
let change = 0;

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
        let scroll = $("#table_container").get(0).scrollHeight;
        $("#purchase_data").append(response);
        $("#item_quantity").val("");
        $("#search").val("").trigger("input");
        $("#search").focus();
        $("#item-quantity-frame").addClass("hidden");
        $("seach-container").addClass("z-10");
        DisplayInfo();
        $("#table_container").scrollTop(scroll);
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
  $("#account-password").focus();
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
  $("#item_quantity").val("");
  $("#item-quantity-frame").addClass("hidden");
});

$("#account-frame-cancel-button").on("click", (event) => {
  event.preventDefault();
  $("#account-password").val("");
  $("#password-confirm-frame").addClass("hidden");
});

function DisplayInfo() {
  $(".item_quantity").each((index, data) => {
    itemQuantity = itemQuantity + parseInt($(data).text());
  });
  $(".item_price").each((index, data) => {
    let array_data = $(data).text().split(" ");
    itemAmountDue = itemAmountDue + parseFloat(array_data[1]);
  });

  $("#total_quantity").text(itemQuantity);
  $("#total_item").html("&#8369; " + itemAmountDue.toFixed(2));
}

$("#btn-process").on("click", (event) => {
  $("#cash-confirm-frame").removeClass("hidden");
});

$("#cash-frame-ok-button").on("click", (event) => {
  let cash = $("#cash_input").val();
  if (cash !== "") {
    TotalCash = cash;
    $("#cash").text(cash.toFixed(2));
    $("#change").text(CalculateChange().toFixed(2));
    $("#cash-confirm-frame").addClass("hidden");
    let cash = $("#cash_input").val("");
  } else {
    notif("error", "Cash amount is required!");
  }
});

$("#cash-frame-cancel-button").on("click", () => {
  $("#cash-confirm-frame").addClass("hidden");
});

function CalculateChange() {
  return TotalCash - itemAmountDue;
}

function PrintProcess() {
  $(".item_action").addClass("hidden");
  $("#purchase_data").append(
    ' <tr class=" costumer_purchase_data border-2 h-6">' +
      '<th class="text-center"></th>' +
      '<th class="text-center"></th>' +
      '<th class="text-center">' +
      "</th>" +
      "</tr>"
  );

  $("#purchase_data").append(
    ' <tr class=" costumer_purchase_data border-2 h-6">' +
      '<th class="text-center"></th>' +
      '<th class="text-center">Amount Due</th>' +
      '<th class="text-center">' +
      itemAmountDue +
      "</th>" +
      "</tr>"
  );

  $("#purchase_data").append(
    ' <tr class=" costumer_purchase_data border-2 h-6">' +
      '<th class="text-center"></th>' +
      '<th class="text-center">Change</th>' +
      '<th class="text-center">' +
      itemChange +
      "</th>" +
      "</tr>"
  );

  let printTable = document.getElementById("purchase_data");
  let printFrame = window.open("", "", "width=700,height=700");
  printFrame.document.write(
    "<!DOCTYPE html>" +
      '<html lang="en">' +
      "<head>" +
      '<meta charset="UTF-8">' +
      '<meta http-equiv="X-UA-Compatible" content="IE=edge">' +
      '<meta name="viewport" content="width=device-width, initial-scale=1.0">' +
      '<link rel="stylesheet" href="assets/tailwind.css">' +
      '<link rel="stylesheet" href="assets/font.css">' +
      '<link rel="stylesheet" href="assets/background.css">' +
      '<link rel="stylesheet" href="assets/table.css">' +
      '<script src="/assets/jquery.js"></script>' +
      "<title>Cashier Panel-PoS</title>" +
      "</head>" +
      '<body id="#body" class="text-black">'
  );
  printFrame.document.write(
    '<div class="grid mt-2 w-full text-center"><img src="assets/logo.png" class="w-24 mr-auto ml-auto h-24"><span>InterConnected Point Of Sales</span></div>'
  );
  printFrame.document.write("<br>");

  printFrame.document.write(
    "<span  class='text-xl font-semibold'>Store:</span><span class='text-xl font-semibold'>" +
      storeName +
      "</span>"
  );
  printFrame.document.write("<br>");
  printFrame.document.write(
    "<span  class='text-xl font-semibold'>Transaction ID:</span><span class='text-xl font-semibold'>" +
      transactionID +
      "</span>"
  );
  printFrame.document.write("<br>");
  printFrame.document.write(
    "<span  class='text-xl font-semibold'>Date:</span><span class='text-xl font-semibold'>" +
      transactionDate +
      "</span>"
  );
  printFrame.document.write("<br>" + "<br>");
  printFrame.document.write(printTable.outerHTML);
  printFrame.document.write(
    "</body>" +
      '<script src="/configs/js/response_handler.js"></script>' +
      '<script src="/configs/js/cashier_panel_navigation.js"></script>' +
      '<script src="/configs/js/notification_banner.js"></script>' +
      '<script src="/configs/js/quagga_process.js"></script>' +
      '<script src="/configs/js/cashier_panel.js"></script>' +
      "</html>"
  );
  setTimeout(() => {
    printFrame.print();
    printFrame.close();
  }, 1000);
  $(".item_action").removeClass("hidden");
  onPrintDialogClose();
}

function onPrintDialogClose() {
  $(".costumer_purchase_data").remove();
}

window.addEventListener("afterprint", () => {
  $(".costumer_purchase_data").remove();
});

$(document).ready(() => {
  if (document.cookie.includes("token")) {
    $.ajax({
      type: "post",
      url: "configs/php/loadStoreDetail.php",
      data: {},
      success: function (response) {
        let handler = response_handler(response);
        if (handler.code == 200) {
          storeName = handler.message;
        } else if (handler.code == 401) {
          notif("error", handler.message);
        }
      },
    });
  }
  transactionID = generateUID();

  transactionDate = getDate();
});

function generateUID() {
  let uid = "";
  for (let i = 0; i <= 16; i++) {
    uid = uid + Math.floor(Math.random() * 9);
  }
  return uid;
}

function getDate() {
  let date = new Date();
  return (
    date.toDateString() +
    " " +
    date.getHours() +
    ":" +
    date.getMinutes() +
    ":" +
    date.getSeconds()
  );
}
