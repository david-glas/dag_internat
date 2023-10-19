<!DOCTYPE html>
<html>
<head>
    <title>QR Code Test Generierung</title>
    <!-- Include Bootstrap 5 CSS and JavaScript -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

      <!-- QR -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body>

<div class="container">
    <h2>QR Test</h2>
    <form id="myForm">
        <div class="mb-3">
            <label for="userId" class="form-label">User ID:</label>
            <input type="number" class="form-control" id="userId" name="userId" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date :</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="mb-3">
            <label for="tod" class="form-label">Time of Day:</label>
            <input type="number" class="form-control" id="tod" name="tod" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">QR Code</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body mt-3 mb-3">
      <div id="qrcode" style="  text-align: center;
                                        display: flex;
                                        flex-direction: column;
                                        justify-content: center;
                                        align-items: center;
                                        height: 100%;">
      </div>
      <div id="qrtext" hidden></div>
      </div>
    </div>
  </div>
</div>

<script>
    // Show the modal when the form is submitted
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("#myForm");
        form.addEventListener("submit", function (e) {
            e.preventDefault(); // Prevent the form from actually submitting

            // Make an AJAX call using fetch() to get the encrypted data
            fetch('process_form.php', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.text())
            .then(data => {
                var qrcode = document.querySelector("#qrcode");
                qrcode.innerHTML = "";
                var qrcode = new QRCode("qrcode", data);
                const myModal = new bootstrap.Modal(document.querySelector('#qrModal'));
                myModal.show();
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>

</body>
</html>
