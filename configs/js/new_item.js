$("#item_description").on("input", (event) => {
  event.preventDefault();
  $("#add_item_character_counter").text(
    "Characters:" + event.target.value.length + "/250"
  );
});

$("#newItem").on("submit", (event) => {
  event.preventDefault();
  let data = $("#newItem").serializeArray();
  $.ajax({
    type: "post",
    url: "/configs/php/new_item.php",
    data: data,
    success: function (response) {
      console.log(response);
      let handler = response_handler(response);
      if (handler.code == 200) {
        $(".item_rows").remove();
        displayItems();
        notif("accept", handler.message);
        document.cookie = obj.token;
      } else {
        notif("error", handler.message);
      }
    },
  });
});

function displayItems() {
  $.ajax({
    type: "post",
    url: "/configs/php/display_item.php",
    success: function (response) {
      $("#items_table").append(response);
    },
  });
}
