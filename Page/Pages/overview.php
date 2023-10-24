<div class="container">
  <canvas id="myChart" style="width:100%"></canvas>
  <?php printWeekButtons(); ?>
  <div class="container table-responsive my-3">
    <table class="table table-striped table-hover table-responsive">
      <thead>
        <tr>
          <th scope="col">Datum</th>
          <th scope="col">Wochentag</th>
          <th scope="col">Gericht</th>
          <th scope="col">Essen ID</th>
          <th scope="col">Essensname</th>
          <th scope="col">Anzahl</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php fillMenuData() ?>
      </tbody>
    </table>
  </div>
</div>

<?php
printWeekButtons();

makeChartScript();

function fillMenuData() {
  $week_offset = 0;
  if (isset($_GET['week'])) {
    $week_offset = $_GET['week'];
  }

  $menuConn = new Menu();
  $menus = $menuConn->GetMenuForWeek($week_offset);
  $userConn = new User();
  $allUsers = $userConn->GetAllUsers('where role_id in (2,3,4)');

  $lastDay = '';

  if ($menus != null) {
    foreach ($menus as $menu) {
      if ($lastDay != $menu['day']) {
        echo
        '<tr>
          <th rowspan="7" class="align-middle">'.$menu['day'].'</th>
          <th rowspan="7" class="align-middle">'.$menu['day_name'].'</th>
          <td>'.$menu['type'].'</td>  
          <td>'.$menu['food_id'].'</td>
          <td>'.$menu['name'].'</td>
          <th>'.$menu['amount'].'</th>
          <td>
            <button type="button" class="btn btn-warning btn-sm float-end" data-bs-toggle="modal" data-bs-target="#show'.$menu['menu_id'].'">
              <i class="bi bi-display"></i><span>  Anzeigen</span>
            </button>
          </td>
        </tr>';
      }
      else {
        echo
        '<tr>
          <td>'.$menu['type'].'</td>  
          <td>'.$menu['food_id'].'</td>
          <td>'.$menu['name'].'</td>
          <th>'.$menu['amount'].'</th>
          <td>
            <button type="button" class="btn btn-warning btn-sm float-end" data-bs-toggle="modal" data-bs-target="#show'.$menu['menu_id'].'">
              <i class="bi bi-display"></i><span>  Anzeigen</span>
            </button>
          </td>
        </tr>';
      }
      echo
      '<div class="modal fade" id="show'.$menu['menu_id'].'">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">'.$menu['day'].', '.$menu['day_name'].' - '.$menu['type'].'</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="container-fluid">
                <div class="row mb-3">
                  <div class="col-2"></div>
                  <div class="col-4"><b>Name</b></div>
                  <div class="col-6"><b>Abgeholt</b></div>
                </div>';
                $used_userIds = printUsersByMenuID($userConn, $menu['menu_id']);
        echo    '
              </div>
              <hr class="divider">
              <div class="container-fluid">
                <div class="row">
                  <form method="POST" action="Components/overview_functions.php">
                    <div class="col-2">
                      <button type="submit" name="button" value="add" class="btn btn-sm btn-success"><i class="bi bi-plus-lg"></i></button>
                    </div>
                    <div class="col-4">
                      <select class="form-select form-select-sm" name="add">
                        <option value="-1_-1" selected>Name</option>';
                        foreach ($allUsers as $user) {
                          if (!in_array($user['user_id'], $used_userIds)) {
                            echo '<option value="'.$user['user_id'].'_'.$menu['menu_id'].'">'.$user['firstname'].' '.$user['lastname'].'</option>';
                          }
                        }
        echo          '</select>
                    </div>
                    <div class="col-6">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="set_time">
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>';

      $lastDay = $menu['day'];
    }
  }
}
function printUsersByMenuID(User $userConn, $menu_id) {
  $users = $userConn->GetUsersByMenuID($menu_id);
  $used_userIds = [];
  $week = 0;
  if (isset($_GET['week'])) {
    $week = $_GET['week'];
  }
  
  foreach ($users as $user) {
    echo
    '<div class="row mt-1">
      <form method="POST" action="Components/overview_functions.php">
        <div class="col-2">
          <button type="submit" name="delete" value="'.$user['user_id'].'_'.$menu_id.'" class="btn btn-sm btn-danger"><i class="bi bi-x"></i></button>
        </div>
        <input value ="'.$week.'" name="week" hidden>
      </form>
      <div class="col-4">'.$user['name'].'</div>
      <div class="col-6">'.printZusage($user['time']).'</div>
    </div>';
    $used_userIds[] = $user['user_id'];
  }
  return $used_userIds;
}
function printZusage($time) : string {
  if ($time == null) {
    return "Nein";
  }
  else {
    return $time;
  }
}
function makeChartScript() {
  $menuConn = new Menu();
  $week_offset = 0;
  if (isset($_GET['week'])) {
    $week_offset = $_GET['week'];
  }
  $menus = $menuConn->GetMenuForWeek($week_offset);

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

function printWeekButtons() {
  $week = 0;
  if(isset($_GET['week'])) {
    $week = $_GET['week'];
  }
  $weekdec = $week + 7;
  $weekinc = $week - 7;

  echo
  '<div class="container text-center mt-2"
    <div class="btn-group" role="group" aria-label="Basic example">
      <a href="?page=dashboard&week='.$weekdec.'" class="btn btn-primary"><i class="bi bi-caret-left-fill"></i></a>
      <a href="?page=dashboard&week=0" class="btn btn-primary">Aktuelle Woche</a>
      <a href="?page=dashboard&week='.$weekinc.'" class="btn btn-primary"><i class="bi bi-caret-right-fill"></i></a>
    </div>
  </div>';
}

?>