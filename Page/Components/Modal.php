<?php
echo '
      <!-- Modal -->
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Passwort muss geändert werden!</h1>
            </div>
            <div class="modal-body">
            <form>
            <div class="mb-3">
              <label for="pw" class="col-form-label">Passwort:</label>
              <input type="password" style="-webkit-text-security: square;"  class="form-control" id="pw">
            </div>
            <div class="mb-3">
              <label for="pwagain" class="col-form-label">Passwort wiederholen:</label>
              <input type="password" style="-webkit-text-security: square;" class="form-control" id="pwagain"></input>
            </div>
          </form>
            </div>
            <span id="msg"></span>
            <div class="modal-footer">
              <button type="button" id="savepw" class="btn btn-primary">Sichern</button>
            </div>
          </div>
        </div>
      </div>';
?>