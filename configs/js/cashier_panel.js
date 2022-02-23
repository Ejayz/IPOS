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
let is_email = false;

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

function SelectItem(data) {
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
  itemQuantity = 0;
  itemAmountDue = 0;
}

$("#btn-process").on("click", (event) => {
  $("#cash-confirm-frame").removeClass("hidden");
});

$("#cash-frame-ok-button").on("click", (event) => {
  TotalCash = $("#cash_input").val();

  if (TotalCash !== "") {
    if (TotalCash >= itemAmountDue) {
      $("#cash").html("&#8369; " + parseFloat(TotalCash).toFixed(2));
      $("#change").html(CalculateChange().toFixed(2));
      $("#cash-confirm-frame").addClass("hidden");
      $("#cash_input").val("");
      $("#print_option").removeClass("hidden");
    } else {
      notif("warning", "Cash should be higher than amount due.");
    }
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
  $("#cash").html("&#8369; " + TotalCash);
  $("#total_quantity").html(quantity);
  $("#total_item").html("&#8369; " + itemAmountDue);
  $("#change").html(change);
  $("#token_natural").val(getToken());
});

function getToken() {
  let token = document.cookie.split(";");
  let token_string = "";
  for (let i = 0; i < token.length; i++) {
    if (token[i].includes("token")) {
      token_string = token[i].split("=")[1];
      break;
    }
  }
  return token_string;
}

function generateUID() {
  let uid = "";
  ``;
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

function stripId(id) {
  let strippedId = id.split(":");
  if (stripId.length !== 2) {
    return false;
  } else {
    return stripId[0];
  }
}

function cleanID(element) {}

function TransactionHandler() {
  let data = {
    transaction_id: transactionID,
    amount_due: itemAmountDue,
    change: change,
    total_cash: TotalCash,
    total_item_quantity: itemQuantity,
    is_email: is_email,
    email: $("#costumer-email").val(),
    token: $("#token_natural").val(),
  };
  $.ajax({
    type: "post",
    url: "configs/php/record_account_transaction.php",
    data: data,
    success: function (response) {
      console.log(response);
    },
  });
}

function TableHandler() {
  let data = {};
  let table = document.getElementById("purchase_data");
  let rows_length = table.rows.length;

  for (let i = 0; i < rows_length; i++) {
    if (i !== 0) {
      data = {
        item_id: table.rows.item(i).cells[0].innerText,
        item_quantity: table.rows.item(i).cells[1].innerText,
        item_description: table.rows.item(i).cells[2].innerText,
        item_price: table.rows.item(i).cells[3].innerText,
        transaction_id: transactionID,
        transaction_date: transactionDate,
        token: $("#token_natural").val(),
      };

      $.ajax({
        type: "post",
        url: "configs/php/record_transaction.php",
        data: data,
        success: function (response) {
          if (response == 200) {
            console.log("Item inserted");
          } else {
            console.log("Send this to support if having a problem.:" + response);
          }
        },
      });
    }
  }
}

function tableFormater() {
  let data =
    "<table style='width:100%;text-align:center;'>" +
    "<tr>" +
    "<th class='text-center'>QTY</th>" +
    "<th class='text-center'>Description</th>" +
    "<th class='text-center'>Amount</th>" +
    "</tr>";
  let table = document.getElementById("purchase_data");
  let rows_length = table.rows.length;
  for (let i = 0; i < rows_length; i++) {
    if (i !== 0) {
      if (i % 2 == 0) {
        data =
          data +
          "  <tr style='background-color:#b8b6b2;'>" +
          "<td >" +
          table.rows.item(i).cells[1].innerText +
          "</td>" +
          "<td >" +
          table.rows.item(i).cells[2].innerText +
          "</td>" +
          "<td >" +
          table.rows.item(i).cells[3].innerText +
          "</td>" +
          "</tr>";
      } else {
        data =
          data +
          "<tr style='background-color:#c70092;'>" +
          "<td >" +
          table.rows.item(i).cells[1].innerText +
          "</td>" +
          "<td >" +
          table.rows.item(i).cells[2].innerText +
          "</td>" +
          "<td >" +
          table.rows.item(i).cells[3].innerText +
          "</td>" +
          "</tr>";
      }
    }
  }
  data = data + "</table>";
  return data;
}

$("#print_button").on("click", (event) => {
  PrintProcess();
});

$("#email_button").on("click", (event) => {
  $("#print_option").addClass("hidden");
  $("#email-confirm-frame").removeClass("hidden");
  is_email = true;
});

$("#email-frame-ok-button").on("click", (event) => {
  let costumer_email = $("#costumer-email").val();

  if (costumer_email == "" || !costumer_email.includes("@")) {
    notif("error", "Email is invalid please enter a valid email");
  } else {
    notif("accept", "Your reciept will be sent in a few second.Please wait...");
    let table_data = tableFormater();
    $(".item_quantity").each((index, data) => {
      itemQuantity = itemQuantity + parseInt($(data).text());
    });
    $(".item_price").each((index, data) => {
      let array_data = $(data).text().split(" ");
      itemAmountDue = itemAmountDue + parseFloat(array_data[1]);
    });
    change = CalculateChange();

    TransactionHandler();
    TableHandler();
    data = {
      email: costumer_email,
      store_name: storeName,
      transaction_id: transactionID,
      table_data: table_data,
      amount_due: "&#8369; " + itemAmountDue.toFixed(2),
      cash: "&#8369; " + TotalCash,
      total_quantity: itemQuantity,
      change: "&#8369; " + change.toFixed(2),
    };
    $.ajax({
      type: "post",
      url: "configs/php/send_email.php",
      data: data,
      success: function (response) {
        console.log(response);

        transactionID = generateUID();
        transactionDate = getDate();
        $("#cash").html("&#8369; " + 0);
        $("#total_quantity").html(0);
        $("#total_item").html("&#8369; " + 0);
        $("#change").html("&#8369; " + 0);
        $("#token_natural").val(getToken());
        $(".items_data").remove();
        $("#email-confirm-frame").addClass("hidden");
        itemQuantity = 0;
        itemAmountDue = 0;
      },
    });
  }
});
$("#email-frame-cancel-button").on("click", (event) => {
  $("#email-confirm-frame").addClass("hidden");
});
