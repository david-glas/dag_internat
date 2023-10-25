<div class="d-flex justify-content-center align-items-center mb-3">
  <button class="btn btn-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-person-fill"></i>  Neuen Benutzer hinzufügen</button>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel"><i class="bi bi-person-fill"></i>  Benutzer hinzufügen</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="container">
      <form class="form-floating" method="POST" action="Components/user_functions.php">
        <div class="form-floating mb-2">
          <input type="text" class="form-control" id="svnr_input" name="svnr_input" maxlength="10">
          <label for="svnr_input">Sozialversicherungsnummer</label>
        </div>
        <div class="form-floating mb-2">
          <input type="text" class="form-control" id="firstname_input" name="firstname_input">
          <label for="firstname_input">Vorname</label>
        </div>
        <div class="form-floating mb-2">
          <input type="text" class="form-control" id="lastname_input" name="lastname_input">
          <label for="lastname_input">Nachname</label>
        </div>
        
        <div class="form-floating mb-2">
          <input type="password" class="form-control" id="password_input" name="password_input">
          <label for="password_input">Passwort</label>
        </div>
        <div class="form-floating mb-4">
          <select class="form-select" id="role_select" name="role_select">
            <?php fillRoleSelect(3) ?>
          </select>
          <label for="role_select">Rolle</label>
        </div>
        <div class="form-floating mt-4">
          <button type="submit" name="action" value="create" class="btn btn-success"><i class="bi bi-check-lg d-inline"></i>  Benutzer anlegen</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container table-responsive">
  <table class="table table-striped table-hover table-responsive">
    <thead>
      <tr>
        <th scope="col" style="width: 5%;">#</th>
        <th scope="col" style="width: 15%;">Vorname</th>
        <th scope="col" style="width: 20%;">Nachname</th>
        <th scope="col" style="width: 25%;">SV-Nr</th>
        <th scope="col" style="width: 20%;">Rolle</th>
        <th scope="col" style="width: 15%;"></th>
      </tr>
    </thead>
    <tbody>
      <?php fillUserData() ?>
    </tbody>
  </table>

</div>

<?php
  function fillUserData() {
    $userConn = new User();
    $users = $userConn->GetAllUsers();

    if ($users != null) {
      foreach ($users as $user) {
        echo  '<tr>
                <th scope="row">'. $user['user_id'] . '</th>
                <td>'. $user['firstname'] .'</td>
                <td>'. $user['lastname'] .'</td>
                <td>'. $user['svnr'] .'</td>
                <td>'. $user['role'] .'</td>
                <td><button type="button" class="btn btn-warning btn-sm float-end" data-bs-toggle="offcanvas" data-bs-target="#change'. $user['user_id']  .'" aria-controls="change'. $user['user_id']  .'" id="'. $user['user_id'] .'">
                  <i class="bi bi-gear-fill"></i><span>  Ändern</span>
                </button></td>
              </tr>';
        
        echo '<div class="offcanvas offcanvas-end" tabindex="-1" id="change'. $user['user_id']  .'" aria-labelledby="change'. $user['user_id']  .'">
                <div class="offcanvas-header">
                  <h5 class="offcanvas-title" id="change'. $user['user_id']  .'"><i class="bi bi-gear-fill"></i>  Benutzer ändern</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                  <div class="container">
                    <form class="form-floating" method="POST" action="Components/user_functions.php">
                      <div class="form-floating mb-2">
                        <input type="hidden" value="'. $user['user_id'] .'" class="form-control" id="userID_input" name="userID_input">
                        <input type="text" value="'. $user['user_id'] .'" class="form-control" id="userID_inputhidden" name="userID_inputhidden" disabled readonly>
                        <label for="userID_inputhidden">Benutzer ID</label>
                      </div>
                      <div class="form-floating mb-2">
                        <input type="text" value="'. $user['svnr'] .'" class="form-control" id="svnr_input" name="svnr_input" maxlength="10">
                        <label for="svnr_input">Sozialversicherungsnummer</label>
                      </div>
                      <div class="form-floating mb-2">
                        <input type="text" value="'. $user['firstname'] .'" class="form-control" id="firstname_input" name="firstname_input">
                        <label for="firstname_input">Vorname</label>
                      </div>
                      <div class="form-floating mb-2">
                        <input type="text" value="'. $user['lastname'] .'"  class="form-control" id="lastname_input" name="lastname_input">
                        <label for="lastname_input">Nachname</label>
                      </div>
                      <div class="form-floating mb-2">
                        <input type="password" class="form-control" id="password_input'.$user['user_id'].'" name="password_input" disabled>
                        <label for="password_input'.$user['user_id'].'">Passwort</label>
                      </div>
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="password_change'.$user['user_id'].'" name="password_change" value="set">
                        <label class="form-check-label" for="password_change'.$user['user_id'].'">
                            Passwort ändern
                        </label>
                      </div>
                      <script>
                      const disablePasswordCheckbox'.$user['user_id'].' = document.getElementById("password_change'.$user['user_id'].'");
                      const passwordInput'.$user['user_id'].' = document.getElementById("password_input'.$user['user_id'].'");

                      disablePasswordCheckbox'.$user['user_id'].'.addEventListener("click", function () {
                        if (disablePasswordCheckbox'.$user['user_id'].'.checked) {
                            passwordInput'.$user['user_id'].'.disabled = false;
                        } else {
                            passwordInput'.$user['user_id'].'.disabled = true;
                        }
                      });
                      </script>
                      <div class="form-floating mb-2 mt-3">
                        <select class="form-select" id="role_select" name="role_select">';
                          fillRoleSelect($user['role_id']);
          echo          '</select>
                        <label for="role_select">Rolle</label>
                      </div>
                    <div class="form-floating mt-4">
                      <button type="submit" name="action" value="change" class="btn btn-success me-1"><i class="bi bi-check-lg"></i>  Benutzer ändern</button>
                      <button type="submit" name="action" value="delete" class="btn btn-danger"><i class="bi bi-trash-fill"></i>  Benutzer löschen</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>';
      }
    }
  }

  function fillRoleSelect($role_id) {
    $userConn = new User();
    $roles = $userConn->GetAllRoles();

    if ($roles != null) {
      for($i=0; $i < count($roles); $i++) {
        echo '<option value="'. $roles[$i]['role_id'] .'"';
        if ($role_id == $i+1) { 
          echo ' selected'; 
        }
        echo '>'. $roles[$i]['name'] .'</option>';
      }
    }
  }
?>