<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<canvas id="myChart" style="width:100%"></canvas>

<script>
const xValues = ['11.03.1996','12.03.1996','13.03.1996','14.03.1996'];

new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{ 
      data: [860,1140,1060,1060,1070],
      borderColor: "red",
      fill: false
    }, { 
      data: [1600,1700,1700,1900],
      borderColor: "green",
      fill: false
    }, { 
      data: [300,700,2000,5000],
      borderColor: "blue",
      fill: false
    }]
  },
  options: {
    legend: {display: true}
  }
});
</script>
