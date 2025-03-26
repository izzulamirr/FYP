<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>
    <div id="reader" style="width: 500px;"></div>
    <p>Scanned Result: <span id="result"></span></p>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('result').innerText = decodedText;
        }

        let scanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
        scanner.render(onScanSuccess);
    </script>
</body>
</html>
