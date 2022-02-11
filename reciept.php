<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/tailwind.css">
    <link rel="stylesheet" href="assets/font.css">
    <link rel="stylesheet" href="assets/background.css">
    <link rel="stylesheet" href="assets/table.css">
    <script src="/assets/jquery.js"></script>
    <script src="/assets/quagga.min.js"></script>

</head>

<body>
    <div id="appends" class="">
        <h1>je;;ps</h1>
    </div>


</body>
<script>
    $("#appends").append(filter(window.location.search.split("?data=")[1]))

function filter(data) {
    while (true) {
        console.log(data.includes("%20%"));
        if (data.includes('%20')) {
            data = data.replace("%20", " ")
        } else if (data.includes("%3C")) {
            data = data.replace("%3C", "<")

        } else if (data.includes("%3E")) {
            data = data.replace("%3E", ">")

        } else if (data.includes("%22")) {
            data = data.replace("%22", "\"")

        } else if (data.includes("%27")) {
            data = data.replace("%27", "'")

        } else if (data.includes("%E2%82%B1")) {
            data = data.replace("%E2%82%B1", "&#8369; ")

        } else {
            break;
        }

    }
    console.log(data)
    return data;
}
window.print();
</script>

</html>