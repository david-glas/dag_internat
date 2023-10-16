<div class="container">
    <h1>Scan QR Codes</h1>
    <div class="section">
        <div id="my-qr-reader">
        </div>
        <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Qr scan</h1>
                        <button id="closeButtonId" type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body mt-3 mb-3">
                        <p id="symbol"></p>
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
                scanModal.toggle();

                requestData = {
                    action: "decrypt",
                    text: decodeText
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
                        //var scanText = document.getElementById("scanText");
                        //scanText.innerHTML = data;
                        setModal(data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                flag = false;
                setTimeout(() => flag = true, 2000);
            }

        }

        function setModal(data) {
            var symbol = document.getElementById("symbol");
            var scan = document.getElementById("scanText");

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
                    if (result.length == 0) {

                        symbol.style.color = "red";
                        symbol.style.fontSize = 30;
                        symbol.innerHTML = "X";
                    } else {
                        symbol.style.color = "green";
                        symbol.style.fontSize = 30;
                        symbol.innerHTML = "Y";
                        scan.innerHTML = "";
                        result.forEach(function (order) {
                            scan.innerHTML += "<p>" + order['type'] + "</p>";
                        })
                    };
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
    });
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

    button {
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

    button:hover {
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