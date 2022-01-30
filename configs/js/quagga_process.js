let quagga_state = false;
let selectedCamera;
let readerTypes = [
  "code_128_reader",
  "ean_reader",
  "ean_8_reader",
  "code_39_reader",
  "code_39_vin_reader",
  "codabar_reader",
  "upc_reader",
  "upc_e_reader",
  "i2of5_reader",
  "i2of5_reader",
  "code_93_reader",
];

let quaggaState = {
  inputStream: {
    type: "LiveStream",
    constraints: {
      facingMode: "environment",
      aspectRatio: { min: 1, max: 1 },
      deviceId: "",
    },
  },
  locator: {
    patchSize: "medium",
    halfSample: true,
  },
  numOfWorkers: 2,
  frequency: 10,
  decoder: {
    readers: readerTypes,
  },
  locate: true,
};

$(document).ready(function () {
  navigator.mediaDevices
    .getUserMedia({ video: true })
    .then((stream) => {
      stream.getVideoTracks().forEach(function (track) {
        track.stop();
        getCameraList();
      });
    })
    .catch((e) => {
      notif("error", "Please allow camera access for barcode scanner.");
    });
});

function getCameraList() {
  this.camera = [];
  navigator.mediaDevices.enumerateDevices().then((devices) => {
    for (let i = 0; i < devices.length; i++) {
      if (devices[i].kind == "videoinput") {
        if (devices[i].label != "") {
          let deviceInformation =
            devices[i].label.split(":")[0] + ":" + devices[i].deviceId;
          $("#camera-list").append(
            "<option value='" +
              deviceInformation +
              "'>" +
              deviceInformation +
              "</option>"
          );
        } else {
          this.camera.push("No camera found on this device.");
        }
      }
    }
  });
}

$("#camera-list").on("change", (event) => {
  selectedValue = event.target.value;
  selectedCamera = selectedValue;
  cameraHandler(selectedValue);
});

function cameraHandler(selected_camera) {
  if (selected_camera == "No camera found on this device.") {
    notif("warning", "Invalid camera choice.");
  } else if (selected_camera == "Camera List") {
    notif("warning", "Invalid camera choice.");
  } else {
    let camera_information = selected_camera.split(":");
    quaggaState.inputStream.constraints.deviceId = camera_information[1];
    if (quagga_state) {
      Quagga.stop();
    }
    Quagga.init(quaggaState, (err) => {
      if (err) {
        notif("error", "Quagga intitiation failed please restart this page.");
      }
      quagga_state = true;
      Quagga.start();
      Quagga.onDetected(onDetected);
    });
  }
}

function onDetected(result) {
  let location = window.location.pathname;
  if (location.includes("cashier_panel.php")) {
    $("#search").val(result.codeResult.code).trigger("input");
  } else if (location.includes("new_item.php")) {
    $("#item_id").val(result.codeResult.code).trigger("input");
  }

  Quagga.stop();
  $("#video_feed")[0].pause();
  console.log("Halting barcode reader for 1 second");
  setTimeout(() => {
    cameraHandler(selectedCamera);
  }, 1000);
}

$("#search").on("input", (event) => {
  event.preventDefault();

  $(".results").remove();
  $("seach-container").addClass("z-30");
  let search = event.target.value;
  if (search !== "") {
    $("#search_result").removeClass("hidden");
    $.ajax({
      type: "post",
      url: "/configs/php/search_item.php",
      data: {
        search: search,
      },
      success: function (response) {
        handler = response_handler(response);
        $(".results").remove();
        $("#search_result").append(response);
      },
    });
  } else {
    $("#search_result").removeClass("grid-cols-1");
    $("#search_result").addClass("grid-cols-2");
    $("#search_result").addClass("hidden");
  }
});

$("#results").on("click", (event) => {
  event.preventDefault();
  console.log(event);
});
