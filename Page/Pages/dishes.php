<div class="container">

</div>

<div class="container">
  <h4>Vormittag</h4>
</div>
<div class="container">
  <table class="table table-striped table-hover table-responsive">
    <thead>
      <tr>
        <th scope="col" style="width: 5%;">#</th>
        <th scope="col" style="width: 55%;">Name</th>
        <th scope="col" style="width: 30%;">Menüs</th> 
        <th scope="col" style="width: 10%; text-align: right;"></th>
      </tr>
    </thead>
    <tbody>
      <?php fillDishData(1) ?>
    </tbody>
  </table>
</div>

<div class="container">
  <h4>Mittag</h4>
</div>
<div class="container">
  <table class="table table-striped table-hover table-responsive">
    <thead>
      <tr>
        <th scope="col" style="width: 5%;">#</th>
        <th scope="col" style="width: 55%;">Name</th>
        <th scope="col" style="width: 30%;">Menüs</th> 
        <th scope="col" style="width: 10%; text-align: right;"></th>
      </tr>
    </thead>
    <tbody>
      <?php fillDishData(2) ?>
    </tbody>
  </table>
</div>

<div class="container">
  <h4>Abends</h4>
</div>
<div class="container">
  <table class="table table-striped table-hover table-responsive">
    <thead>
      <tr>
        <th scope="col" style="width: 5%;">#</th>
        <th scope="col" style="width: 55%;">Name</th>
        <th scope="col" style="width: 30%;">Menüs</th> 
        <th scope="col" style="width: 10%; text-align: right;"></th>
      </tr>
    </thead>
    <tbody>
      <?php fillDishData(3) ?>
    </tbody>
  </table>
</div>

<?php
  function fillDishData($timeOfDay) {
    $foodConn = new Food();
    $foods = $foodConn->GetFoodByTod($timeOfDay);

    if ($foods != null) {
      foreach ($foods as $food) {
        echo  '<tr>'.
                '<th scope="row">'. $food['food_id'] . '</th>'.
                '<td>'. $food['name'] .'</td>'.
                '<td>'. $food['menu_name'] .'</td>'.
                '<td><button type="button" class="btn btn-warning btn-sm" id='. $timeOfDay . $food['food_id'] .'>Ändern</button></td>'.
              '</tr>';
      }
    }
  }