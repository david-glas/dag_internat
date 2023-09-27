<style>
  /* Style for the parent div */
  .card-body {
    position: relative;
    height: 150px;
    /* Required for positioning the button */
  }

  /* Style for the button */
  [type=button]:not(#drop) {
    size: 45%;
    /* Set the button to be half the width of the parent */
    position: absolute;
    /* Position it absolutely within the parent */

    bottom: 5px;
    /* Margin from the bottom */
    right: 5px;
    width: 45%;
    /* Margin from the right */
    opacity: 50%;
  }

    /* Style for the button */
    .dropdown {

    /* Set the button to be half the width of the parent */
    position: absolute;
    /* Position it absolutely within the parent */
    bottom: 5px;
    /* Margin from the bottom */
    left: 5px;
    /* Margin from the right */
    opacity: 100%;

  }

  .custom-btn-size {
    font-size: 10px;
  }

  hr {
    margin: 0rem;
    color: grey;
    opacity: 0.25;
  }

  .card-text {
    padding-bottom: 15px;
  }
</style>

<div class="container">
  <ul class="nav nav-pills card-header-pills">
    <li class="nav-item">
      <a id="0" class="nav-link" style="color: #565656">Aktuelle
        Woche</a>
    </li>
    <li class="nav-item">
      <a id="1" class="nav-link" style="color: #565656">Nächste
        Woche</a>
    </li>
    <li class="nav-item">
      <a id="2" class="nav-link" style="color: #565656">Übernächste
        Woche</a>
    </li>
    <li id="spinner" class="nav-item">
      <div class="spinner-border text-secondary" role="status">
      </div>
    </li>
  </ul>
  <br>
  <div id="card-container" class="row row-cols-1 row-cols-md-5 g-4">
  </div>
</div>
<script src="Ajax/JS/menu.js"></script>