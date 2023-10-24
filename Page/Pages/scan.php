<div class="container">
    <h1>Scan QR Codes</h1>
    <div class="section">
        <div id="my-qr-reader">
        </div>
        <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTitle">QR Scan</h1>
                        <button id="closeButtonId" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body mt-3 mb-3">
                        <p id="scanText"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function domReady(fn) {
        if (
            document.readyState === "complete" ||
            document.readyState === "interactive"
        ) {
            setTimeout(fn, 1000);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    domReady(function () {
        var scan = document.getElementById("scanText");
        var title = document.getElementById("modalTitle");

        const scanModal = new bootstrap.Modal(document.getElementById("scanModal"), {});
        var flag = true;
        var modal = document.getElementById("scanModal");

        modal.addEventListener('hidden.bs.modal', function () {
            flag = true;

            // let htmlscanner = new Html5QrcodeScanner(
            //     "my-qr-reader",
            //     { fps: 10, qrbos: 250 }
            // );
            // htmlscanner.render(onScanSuccess);

        });

        function onScanSuccess(decodedText, decodedResult) {
            if (flag) {
                //htmlscanner.clear();

                requestData = {
                    action: "decrypt",
                    text: decodedText
                }

                fetch("Components/encrypt.php", {
                    method: 'POST',
                    body: JSON.stringify(requestData),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        setModal(data);
                    })
                    .catch(error => {
                        title.style.color = "red";
                        title.innerHTML = "Ungültiger QR Code!";
                        scan.style.color = "red";
                        scan.innerHTML = "<h5>Der QR Code ist falsch oder der Scanner hat einen Fehler.</h5>";
                        scanModal.toggle();
                    });
                flag = false;
            }

        }

        function setModal(data) {
            request = {
                action: "getUserMenu",
                userid: data["userid"],
                tod: data["tod"],
                date: data["date"]
            }
            fetch("Components/getUserMenu.php", {
                method: 'POST',
                body: JSON.stringify(request),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(result => {
                    var curDate = new Date().toISOString().slice(0, 10);
                    if (curDate != data["date"]) {
                        const parts = data["date"].split('-');
                        const formattedDate = parts[2] + '.' + parts[1] + '.' + parts[0];
                        scan.innerHTML = "<h5>Falsches Datum! (" + formattedDate + ")";
                    } else {
                        scan.innerHTML = "";
                    }
                    if (result.length == 0) {
                        title.style.color = "red";
                        title.innerHTML = "Ungültig!";
                        scan.style.color = "red";
                        scan.innerHTML += "<h5>" + data['name'] + " hat kein Essen bestellt.</h5>";
                    } else {
                        if (result[0]["time"] == null) {
                            title.style.color = "green";
                            title.innerHTML = "Gültig!";
                            scan.style.color = "green";
                            scan.innerHTML += "<h5>" + data['name'] + " hat folgendes Essen bestellt:</h5><br>";
                            result.forEach(function (order) {
                                scan.innerHTML += "<p class='mb-1'><b>▸   " + order['type'] + ": " + order['name'] + "</b></p>";
                            })
                        } else {
                            title.style.color = "red";
                            title.innerHTML = "Ungültig!";
                            scan.style.color = "red";
                            scan.innerHTML += "<h5>Essen von " + data['name'] + " wurde bereits abgeholt.</h5>";
                        }

                    }
                    scanModal.toggle();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        let htmlscanner = new Html5QrcodeScanner(
            "my-qr-reader",
            { fps: 10, qrbos: 250 }
        );
        htmlscanner.render(onScanSuccess);

        var btn = document.getElementById("html5-qrcode-button-camera-permission");
        if (btn != null) {
            btn.innerHTML = "Kamerarechte anfragen";
        }
        setTimeout(makeGerman, 1500)

    });

    function makeGerman() {
        var btn = document.getElementById("html5-qrcode-button-camera-start");

        if (btn != null) {
            btn.innerHTML = "Starte Scannen";
        }
        var btn = document.getElementById("html5-qrcode-button-camera-stop");

        if (btn != null) {
            btn.innerHTML = "Stoppe Scannen";
        }
    }
</script>
<style>
    .section {
        background-color: #ffffff;
        padding: 50px 30px;
        border: 1.5px solid #b2b2b2;
        border-radius: 0.25em;
        box-shadow: 0 20px 25px rgba(0, 0, 0, 0.25);
    }

    #my-qr-reader {
        padding: 20px !important;
        border: 1.5px solid #b2b2b2 !important;
        border-radius: 8px;
    }

    #my-qr-reader img[alt="Info icon"] {
        display: none;
    }

    #my-qr-reader img[alt="Camera based scan"] {
        width: 100px !important;
        height: 100px !important;
    }

    #html5-qrcode-anchor-scan-type-change {
        display: none !important;
    }

    [id^=html5-qrcode] {
        padding: 10px 20px;
        border: 1px solid #b2b2b2;
        outline: none;
        border-radius: 0.25em;
        color: white;
        font-size: 15px;
        cursor: pointer;
        margin-top: 15px;
        margin-bottom: 10px;
        background-color: #008000ad;
        transition: 0.3s background-color;
    }

    [id^=html5-qrcode]:hover {
        background-color: #008000;
    }

    #html5-qrcode-anchor-scan-type-change {
        text-decoration: none !important;
        color: #1d9bf0;
    }

    video {
        width: 100% !important;
        border: 1px solid #b2b2b2 !important;
        border-radius: 0.25em;
    }
</style>