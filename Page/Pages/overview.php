<div class="container">
  <canvas id="myChart" style="width:100%"></canvas>

  <div class="container table-responsive my-3">
    <table class="table table-striped table-hover table-responsive">
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
        <?php fillMenuData() ?>
      </tbody>
    </table>
  </div>
</div>

<?php

makeChartScript();

function fillMenuData() {
  $menuConn = new Menu();
  $menus = $menuConn->GetMenuForWeek();

  if ($menus != null) {
    foreach ($menus as $menu) {
      echo
      '<tr>
        <td>'.$menu['food_id'].'</td>
        <td>'.$menu['name'].'</td>
        <td>'.$menu['type'].'</td>
        <td>'.$menu['day'].'</td>
        <td>'.$menu['day_name'].'</td>
        <th>'.$menu['amount'].'</td>
      </tr>';
    }
  }
}

function makeChartScript() {
  $menuConn = new Menu();
  $menus = $menuConn->GetMenuForWeek();

  if ($menus != null) {
    echo
    '<script>
      const xValues = ';

    fillxValues($menus);

    echo
      'new Chart("myChart", {
      type: "bar",
      data: {
        labels: xValues,
        datasets: [
        { 
          label: "Frühstück",
          data: ';
          fillDatasetData($menus, 1);
    echo 
          'backgroundColor: "rgba(240, 200, 120, 0.8)",
          fill: false
        },
        { 
          label: "Vorspeise",
          data: ';
          fillDatasetData($menus, 2);
    echo 
          'backgroundColor: "rgba(240, 180, 100, 0.8)",
          fill: false
        },
        { 
          label: "Hauptspeise 1",
          data: ';
          fillDatasetData($menus, 3);
    echo 
          'backgroundColor: "rgba(240, 160, 80, 0.8)",
          fill: false
        },
        { 
          label: "Hauptspeise 2",
          data: ';
          fillDatasetData($menus, 4);
    echo 
          'backgroundColor: "rgba(240, 160, 80, 0.8)",
          fill: false
        },
        { 
          label: "Nachspeise",
          data: ';
          fillDatasetData($menus, 5);
    echo 
          'backgroundColor: "rgba(240, 140, 60, 0.8)",
          fill: false
        }, 
        { 
          label: "Abendessen 1",
          data: ';
          fillDatasetData($menus, 6);
    echo 
          'backgroundColor: "rgba(240, 120, 40, 0.8)",
          fill: false
        },
        { 
          label: "Abendessen 2",
          data: ';
          fillDatasetData($menus, 7);
    echo 
          'backgroundColor: "rgba(240, 120, 40, 0.8)",
          fill: false
        }
        ]
      },
      options: {
        legend: {display: true}
      }
    });
    </script>';
  }
}

function fillxValues($menus) {
  $output = '[';
  $lastDay = '01.01.1000';

  foreach($menus as $menu) {
    if ($menu['day'] != $lastDay) {
      $output .= '"'.$menu['day'].'",';
      $lastDay = $menu['day'];
    }
  }
  $output = rtrim($output, ',');
  $output .= '];';
  echo $output;
}

function fillDatasetData($menus, $meal_id) {
  $output = '[';

  foreach($menus as $menu) {
    if($menu['meal_id'] == $meal_id) {
      $output .= $menu['amount'].',';
    }
  }
  $output = rtrim($output, ',');
  $output .= '],';
  echo $output;
}

?>