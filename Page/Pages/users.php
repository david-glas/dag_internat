
<div class="container">
  <h4>Users</h4>
</div>

<div class="container table-responsive">
  <table class="table table-striped table-hover table-responsive">
    <thead>
      <tr>
        <th scope="col" style="width: 5%;">#</th>
        <th scope="col" style="width: 20%;">Vorname</th>
        <th scope="col" style="width: 20%;">Nachname</th>
        <th scope="col" style="width: 25%;">SV-Nr</th>
        <th scope="col" style="width: 20%;">Rolle</th>
        <th scope="col" style="width: 10%; text-align: right;"></th>
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