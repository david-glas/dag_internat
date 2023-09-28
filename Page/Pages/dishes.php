<div class="d-flex justify-content-center align-items-center mb-3">
  <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-cup-hot-fill"></i>  Neues Gericht hinzufügen</button>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel"><i class="bi bi-cup-hot-fill"></i>  Gericht hinzufügen</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="container">
      <form class="form-floating" method="POST" action="Components/dish_functions.php">
        <div class="form-floating mb-2">
          <input type="text" class="form-control" id="firstname_input" name="firstname_input">
          <label for="firstname_input">Name</label>
        </div>
        <?php fillMealChecks(array()) ?>
        <div class="form-floating mt-4">
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
        <th scope="col" style="width: 50%;">Name</th>
        <th scope="col" style="width: 30%;">Menüs</th> 
        <th scope="col" style="width: 15%; text-align: right;"></th>
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
        <th scope="col" style="width: 50%;">Name</th>
        <th scope="col" style="width: 30%;">Menüs</th> 
        <th scope="col" style="width: 15%; text-align: right;"></th>
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
        <th scope="col" style="width: 50%;">Name</th>
        <th scope="col" style="width: 30%;">Menüs</th> 
        <th scope="col" style="width: 15%;"></th>
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
        echo  '<tr>
                <th scope="row">'. $food['food_id'] . '</th>
                <td>'. $food['name'] .'</td>
                <td>'. $food['menu_names'] .'</td>
                <td>
                  <button type="button" class="btn btn-warning btn-sm float-end" id='. $timeOfDay . $food['food_id'] .'>
                    <i class="bi bi-gear-fill"></i><span>  Ändern</span>
                  </button>
                </td>
              </tr>';

        echo  '<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                  <h5 class="offcanvas-title" id="offcanvasRightLabel"><i class="bi bi-cup-hot-fill"></i>  Gericht hinzufügen</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                  <div class="container">
                    <form class="form-floating" method="POST" action="Components/dish_functions.php">
                      <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="firstname_input" name="firstname_input">
                        <label for="firstname_input">Name</label>
                      </div>';
                        fillMealChecks($food['meal_ids']);
        echo          '<div class="form-floating mt-4">
                      <button type="submit" name="action" value="create" class="btn btn-success">Gericht anlegen</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>';
      }
    }
  }

  function fillMealChecks($meal_ids) {
    $foodCon = new Food();
    $menus = $foodCon->GetAllMeals();

    if ($menus != null) {
      for($i=0; $i < count($menus); $i++) {
        echo '<div class="form-check mb-1">
                <input class="form-check-input" type="checkbox" name="meal'. $menus[$i]['meal_id'] .'" value="">
                <label class="form-check-label" for="'. $menus[$i]['meal_id'] .'">'
                  .$menus[$i]['type'].
                '</label>
              </div>';
      }
    }

    function getChecked


  }