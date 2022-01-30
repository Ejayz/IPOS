function response_handler(response) {
  let data = response.split(":");
  if (data.length == 2) {
    return {
      code: data[0],
      message: data[1],
    };
  } else if (data.length == 3) {
    return {
      code: data[0],
      message: data[1],
      token: data[2],
    };
  } else {
    return {
      code: 400,
      message: "Bad Request Error. Server returned wrong data",
    };
  }
}
