<?php
function getLastMonday()
{
  $today = date('N'); // Gibt den aktuellen Wochentag als Zahl (1 für Montag, 7 für Sonntag) zurück

  if ($today === '1') {
    return strtotime('today');
  } else {
    return strtotime('last Monday');
  }
}

$lastMonday = getLastMonday();
function getDateString($day, $lastMonday)
{

  $germanDays = array(
    0 => 'Montag',
    1 => 'Dienstag',
    2 => 'Mittwoch',
    3 => 'Donnerstag',
    4 => 'Freitag',
    5 => 'Samstag',
    6 => 'Sonntag'
  );

  return $germanDays[$day] . ' ' . date('d.m.Y', strtotime("+ {$day} day", $lastMonday) + $day);
}


?>

<div class="container">
  <div class="row row-cols-1 row-cols-md-5 g-4">
   <?php
   for ($i = 0; $i < 5; $i++) {
     $string = getDateString($i, $lastMonday);
     echo '<div class="col">
          <div class="card">
            <div class="card-header">
              <small class="text-muted">' . $string . '</small>
                </div>
                <div class="card-body">
                  <h5 class="card-title">Card 1</h5>
                  <p class="card-text">This is card .</p>
                </div>
                <div class="card-footer">
                  <small class="text-muted">Last updated 3 mins ago</small>
                </div>
              </div>
            </div>';
   }

   ?>
  </div>
</div>
