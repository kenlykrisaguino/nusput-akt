<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Barcode</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        #reader {
            width: 100%;
            max-width: 400px;
            margin: auto;
        }
        #result {
            font-size: 1.2em;
            margin-top: 20px;
        }
        button {
            margin-top: 10px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Scan Barcode</h2>
    <div id="reader"></div>
    <div id="result">Hasil Scan: <span id="output"></span></div>
    <button onclick="startScanner()">Mulai Scan</button>
    <button onclick="stopScanner()">Berhenti Scan</button>

    <script>
        let html5QrCode = new Html5Qrcode("reader");
        let isScanning = false;

        function startScanner() {
            if (!isScanning) {
                html5QrCode.start(
                    { facingMode: "environment" },
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
                    },
                    (decodedText, decodedResult) => {
                        document.getElementById('output').textContent = decodedText;
                    },
                    (errorMessage) => {
                        console.log(errorMessage);
                    }
                ).catch(err => console.log(err));

                isScanning = true;
            }
        }

        function stopScanner() {
            if (isScanning) {
                html5QrCode.stop().then(() => {
                    isScanning = false;
                }).catch(err => console.log(err));
            }
        }
    </script>
</body>
</html>
