function notif(type, message) {
  let id = id_generator();
  $("#notification-banner-container").removeClass("hidden");
  if (type == "error") {
    $("#notification-banner-container").prepend(
      '<div id="notif' +
        id +
        '" class="rounded-md mr-auto ml-auto   bg-red-600 z-50 mt-4 w-64 h-auto ">' +
        '<p class="text-white text-xl ml-4 mt-2">Notification</p>' +
        '<p class="p-4 break">' +
        message +
        "</p>" +
        "<p id='counter" +
        id +
        "'  class='text-xxs'></p>" +
        "</div>"
    );
    hide(id);
  } else if (type == "accept") {
    $("#notification-banner-container").prepend(
      '<div id="notif' +
        id +
        '" class="rounded-md mr-auto ml-auto bg-green-500 z-50 mt-4  w-64 h-auto ">' +
        '<p class="text-white text-xl ml-4 mt-2">Notification</p>' +
        '<p class="p-4 break">' +
        message +
        "</p>" +
        "<p id='counter" +
        id +
        "' class='text-xxs'></p>" +
        "</div>"
    );
    hide(id);
  } else if (type == "warning") {
    $("#notification-banner-container").prepend(
      '<div id="notif' +
        id +
        '" class="rounded-md mr-auto ml-auto  bg-yellow-500 z-50 mt-4 w-64 h-auto ">' +
        '<p class="text-white text-xl ml-4 mt-2">Notification</p>' +
        '<p class="p-4 break">' +
        message +
        "</p>" +
        "<p id='counter" +
        id +
        "' class='text-xxs'></p>" +
        "</div>"
    );
    hide(id);
  }
}

function hide(id) {
  let counter = 6;
  let interv = setInterval(() => {
    if (counter == 0) {
      $("#notif" + id).remove();
      $("#notification-banner-container").addClass("hidden");
      clearInterval(interv);
    } else {
      $("#counter" + id).text("This message will self destruct ETA:" + counter);
      counter--;
    }
  }, 1000);
}

function id_generator() {
  let number = "";
  for (let i = 0; i < 12; i++) {
    number = number + Math.floor(Math.random() * 10);
  }
  return number;
}
