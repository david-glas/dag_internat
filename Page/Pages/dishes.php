<div class="d-flex justify-content-center align-items-center mb-3">
  <button class="btn btn-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-cup-hot-fill"></i>  Neues Gericht hinzufügen</button>
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
          <input type="text" class="form-control" id="foodName_input" name="foodName_input">
          <label for="firstname_input">Name</label>
        </div>
        <?php fillMealChecks("") ?>
        <div class="form-floating mt-4">
          <button type="submit" name="action" value="create" class="btn btn-success"><i class="bi bi-check-lg d-inline"></i> Gericht anlegen</button>
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
                  <button type="button" class="btn btn-warning btn-sm float-end" data-bs-toggle="offcanvas" data-bs-target="#change'. $food['food_id']  .'" aria-controls="change'. $food['food_id']  .'" id="'. $food['food_id'] .'">
                    <i class="bi bi-gear-fill"></i><span>  Ändern</span>
                  </button>
                </td>
              </tr>';

        echo  '<div class="offcanvas offcanvas-end" tabindex="-1" id="change'. $food['food_id']  .'" aria-labelledby="change'. $food['food_id']  .'">
                <div class="offcanvas-header">
                  <h5 class="offcanvas-title" id="offcanvasRightLabel"><i class="bi bi-gear-fill"></i>  Gericht ändern</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                  <div class="container">
                    <form class="form-floating" method="POST" action="Components/dish_functions.php">
                      <div class="form-floating mb-2">
                        <input type="hidden" value="'. $food['food_id'] .'" class="form-control" id="foodID_input" name="foodID_input">
                        <input type="text" value="'. $food['food_id'] .'" class="form-control" id="foodID_input_inputhidden" name="foodID_input_inputhidden" disabled readonly>
                        <label for="foodID_input_inputhidden">Essensnummer</label>
                      </div>  
                    <div class="form-floating mb-2">
                        <input type="text" value="'. $food['name'] .'" class="form-control" id="foodName_input" name="foodName_input">
                        <label for="foodName_input">Name</label>
                      </div>';
                        fillMealChecks($food['meal_ids']);
        echo          '<div class="form-floating mt-4">
                        <button type="submit" name="action" value="change" class="btn btn-success me-1"><i class="bi bi-check-lg"></i>  Gericht ändern</button>
                        <button type="submit" name="action" value="delete" class="btn btn-danger"><i class="bi bi-trash-fill"></i>  Gericht löschen</button>
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
      echo '<div class="container mt-3">
              <h6>Vormittag</h6>
            </div>
            <div class="form-check mb-1">
              <input class="form-check-input" type="checkbox" name="breakfast" value="set" '. setChecked('1', $meal_ids) .'>
              <label class="form-check-label" for="breakfast">
                Frühstück
              </label>
            </div>
            <div class="container mt-3">
              <h6>Mittag</h6>
            </div>
            <div class="form-check mb-1">
              <input class="form-check-input" type="checkbox" name="starter" value="set" '. setChecked('2', $meal_ids) .'>
              <label class="form-check-label" for="starter">
                Vorspeise
              </label>
            </div>
            <div class="form-check mb-1">
              <input class="form-check-input" type="checkbox" name="lunch" value="set" '. setChecked('3', $meal_ids) .'>
              <label class="form-check-label" for="lunch">
                Hauptspeise
              </label>
            </div>
            <div class="form-check mb-1">
              <input class="form-check-input" type="checkbox" name="dessert" value="set" '. setChecked('5', $meal_ids) .'>
              <label class="form-check-label" for="desert">
                Nachspeise
              </label>
            </div>
            <div class="container mt-3">
              <h6>Abends</h6>
            </div>
            <div class="form-check mb-1">
              <input class="form-check-input" type="checkbox" name="dinner" value="set" '. setChecked('6', $meal_ids) .'>
              <label class="form-check-label" for="dinner">
                Abendessen
              </label>
            </div>';
    }
  }
  function setChecked($meal_id, $meal_ids) {
    $test = stringContains($meal_ids, $meal_id);
    if (stringContains($meal_ids, $meal_id)) {
      return 'checked';
    }
  }
  function stringContains($haystack, $needle) {
    // Use strpos to find the position of $needle in $haystack
    $position = strpos($haystack, $needle);
    
    // Check if $position is not false, indicating that $needle was found
    if ($position !== false) {
        return true;
    } else {
        return false;
    }
}