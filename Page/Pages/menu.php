<?php
function getLastMonday()
{
  $today = date('N'); // Gibt den aktuellen Wochentag als Zahl (1 für Montag, 7 für Sonntag) zurück

  if ($today === '1') {
    return date('Y.m.d');
  } else {
    return date('Y.m.d', strtotime('last Monday'));
  }
}

$lastMonday = getLastMonday();
function getDate($day)
{

  $germanDays = array(
    1 => 'Montag',
    2 => 'Dienstag',
    3 => 'Mittwoch',
    4 => 'Donnerstag',
    5 => 'Freitag',
    6 => 'Samstag',
    7 => 'Sonntag'
  );

  if ($day === '1') {
    return $germanDays[$day] . ' ' . date('Y.m.d');
  } else {
    return $germanDays[$day] . ' ' . date('Y.m.d', strtotime('last Monday'));
  }
}
?>

<div class="container">
  <div class="row row-cols-1 row-cols-md-5 g-4">
    <div class="col">
      <div class="card">
        <div class="card-header">
            <small class="text-muted"><?php echo $date; ?></small>
        </div>
        <div class="card-body">
          <h5 class="card-title">Card 1</h5>
          <p class="card-text">This is card 1.</p>
        </div>
        <div class="card-footer">
          <small class="text-muted">Last updated 3 mins ago</small>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-header">
            <small class="text-muted">Montag 21.09.2023</small>
        </div>
        <div class="card-body">
          <h5 class="card-title">Card 1</h5>
          <p class="card-text">This is card 1.</p>
        </div>
        <div class="card-footer">
          <small class="text-muted">Last updated 3 mins ago</small>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-header">
            <small class="text-muted">Montag 21.09.2023</small>
        </div>
        <div class="card-body">
          <h5 class="card-title">Card 1</h5>
          <p class="card-text">This is card 1.</p>
        </div>
        <div class="card-footer">
          <small class="text-muted">Last updated 3 mins ago</small>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-header">
            <small class="text-muted">Montag 21.09.2023</small>
        </div>
        <div class="card-body">
          <h5 class="card-title">Card 1</h5>
          <p class="card-text">This is card 1.</p>
        </div>
        <div class="card-footer">
          <small class="text-muted">Last updated 3 mins ago</small>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card">
        <div class="card-header">
            <small class="text-muted">Montag 21.09.2023</small>
        </div>
        <div class="card-body">
          <h5 class="card-title">Card 1</h5>
          <p class="card-text">This is card 1.</p>
        </div>
        <div class="card-footer">
          <small class="text-muted">Last updated 3 mins ago</small>
        </div>
      </div>
    </div>
  </div>
</div>
