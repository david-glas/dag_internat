
document.addEventListener('DOMContentLoaded', function () {
  var modalBtn = document.querySelector("#qrnav");
  modalBtn.addEventListener('click', function () {
    var qrModal = new bootstrap.Modal(document.getElementById("qrModal"), {});
    var tod = getQR();
    if ([1, 2, 3].includes(tod)) {

      const currentDate = new Date();
      const formattedDate = currentDate.toISOString().slice(0, 10);

      requestData = {
        action: "encrypt",
        tod: tod,
        day: formattedDate
      }

      fetch("Components/encrypt.php", {
        method: 'POST',
        body: JSON.stringify(requestData),
        headers: {
          'Content-Type': 'application/json'
        }
      })
        .then(response => response.text())
        .then(data => {
          var qrcode = new QRCode("qrcode", data);
        })
        .catch(error => {
          console.error('Error:', error);
        });
      var qrcode = document.querySelector("#qrcode");
      qrcode.innerHTML = "";
      qrcode.removeAttribute("hidden");

    } else {
      var qrtext = document.querySelector("#qrtext");
      qrtext.removeAttribute("hidden");
      qrtext.innerHTML = "Es kann derzeit kein QR-Code generiert werden.";
    }
    qrModal.toggle();
  });

});

function getQR() {
  const now = new Date();

  const currentHour = now.getHours();
  const currentMinute = now.getMinutes();

  // Define the time ranges
  const ranges = [
    { startHour: 6, startMinute: 30, endHour: 9, endMinute: 0, todId: 1 },
    { startHour: 11, startMinute: 30, endHour: 14, endMinute: 0, todId: 2 },
    { startHour: 15, startMinute: 0, endHour: 20, endMinute: 0, todId: 3 }
  ];

  // Function to check if the current time is within any of the specified ranges
  for (const range of ranges) {
    const { startHour, startMinute, endHour, endMinute, todId } = range;
    if (
      (currentHour > startHour || (currentHour === startHour && currentMinute >= startMinute)) &&
      (currentHour < endHour || (currentHour === endHour && currentMinute < endMinute))
    ) {
      return todId;
    }
  }

  return 0;

}
