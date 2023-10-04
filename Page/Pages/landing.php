<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-3">Willkommen zur Essensanmeldung!</h1>
        <p class="col-lg-10 fs-4">Bei uns haben Sie die Möglichkeit, aus einer vielfältigen Liste von Mahlzeiten auszuwählen. Unsere Köche bereiten täglich köstliche Gerichte zu, und Sie haben die Freiheit, Ihre Essensauswahl ganz nach Ihrem Geschmack zu gestalten.</p>
      </div>
      <div class="col-md-10 mx-auto col-lg-5">
        <form class="p-4 p-md-5 border rounded-3 bg-body-tertiary" method="POST" action="Components/login.php">
        <h4 class="mb-4">Anmelden</h4>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" placeholder="0000000000" name="svnr">
            <label for="floatingInput">SV-Nummer</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingPassword" placeholder="0000000000" name="password">
            <label for="floatingPassword">Passwort</label>
          </div>
          <button class="w-100 btn btn-lg btn-warning" type="submit">Login</button>
        </form>
      </div>
    </div>
  </div>