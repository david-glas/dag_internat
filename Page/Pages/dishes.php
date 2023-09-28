<div class="container">
  <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Neues Gericht hinzufügen</button>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">Gericht hinzufügen</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="container">
      <form class="form-floating" method="POST" action="Components/dish_functions.php">
        <div class="form-floating mb-2">
          <input type="text" class="form-control" id="firstname_input" name="firstname_input">
          <label for="firstname_input">Name</label>
        </div>
        <?php fillMealChecks() ?>
        <div class="form-floating mb-2">
          <button type="submit" name="action" value="create" class="btn btn-success">Gericht anlegen</button>
        </div>
      </form>
    </div>
  </div>
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

  function fillMealChecks() {
    $foodCon = new Food();
    $menus = $foodCon->GetAllMeals();

    if ($menus != null) {
      for($i=0; $i < count($menus); $i++) {
        echo '<div class="form-check mb-2">'.
                '<input class="form-check-input" type="checkbox" name="meal'. $menus[$i]['meal_id'] .'" value="">'.
                '<label class="form-check-label" for="'. $menus[$i]['meal_id'] .'">'.
                  $menus[$i]['type'].
                '</label>'.
              '</div>';
      }
    }


  }