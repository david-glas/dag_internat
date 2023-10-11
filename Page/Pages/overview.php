<div class="container">
  <canvas id="myChart" style="width:100%"></canvas>

  <table class="table table-striped table-hover table-responsive mt-5">
    <thead>
      <tr>
        <th scope="col">Essen ID</th>
        <th scope="col">Essensname</th>
        <th scope="col">Gericht</th>
        <th scope="col">Datum</th>
        <th scope="col">Wochentag</th>
        <th scope="col">Anzahl</th>
      </tr>
    </thead>
    <tbody>
      
    </tbody>
  </table>
</div>

<?php

function fillMenuData() {
  $menuConn = new Menu();
  
}

?>

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