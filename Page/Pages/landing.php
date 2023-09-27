<div class="form-signin" style="margin:70px">
  <form method="POST" action="Components/login.php">
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    <div class="form-floating">
      <input type="svnr" name="svnr" class="form-control" id="floatingInput" placeholder="0000000000">
      <label for="floatingInput">SVNR</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="T">
      <label for="floatingPassword">Passwort</label>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Anmelden</button>
    <p class="mt-5 mb-3 text-muted">© 2017–2021</p>
  </form>
</div>