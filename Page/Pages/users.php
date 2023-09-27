<div class="container">
  <h4>Users</h4>
</div>

<div class="container">
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Vorname</th>
        <th scope="col">Nachname</th>
        <th scope="col">Sozialversicherungsnummer</th>
        <th scope="col">Rolle</th>
        <th scope="col"></th>
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
        echo  '<tr>'.
                '<th scope="row">'. $user['user_id'] . '</th>'.
                '<td>'. $user['firstname'] .'</td>'.
                '<td>'. $user['lastname'] .'</td>'.
                '<td>'. $user['svnr'] .'</td>'.
                '<td>'. $user['role'] .'</td>'.
                '<td><button type="button" class="btn btn-warning btn-sm" id='. $user['user_id'] .'>Ändern</button></td>'.
              '</tr>';
      }
    }
  }