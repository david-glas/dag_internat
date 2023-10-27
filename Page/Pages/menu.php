<link rel="stylesheet" type="text/css" href="assets/css/menu.css">
<div class="container" style="text-align: center;">

  <style>
  .nav-scroller .nav {
    color: rgba(255, 255, 255, .75);
  }
  .nav-scroller {
    margin-bottom: 20px;
  }

  .nav-scroller .nav-link {
    padding-top: .75rem;
    padding-bottom: .75rem;
    font-size: .875rem;
    color: #6c757d;
    cursor: pointer!important;
  }

  @media (min-width: 769px) {
    .nav-scroller .nav-link:hover {
      color: #007bff!important;
  }
}

  .nav-scroller .active {
    font-weight: 500;
    color: #343a40;
  }

</style>

<div class="container">
<div class="nav-scroller bg-body shadow-sm" style="text-align: center;">
  <nav class="nav justify-content-center" aria-label="Secondary navigation" style="text-align: center;">
  <a id="0" class="nav-link" name="Week" style="color: #565656; display:inline-block; float: none;">Aktuelle Woche</a>
  <a id="1" class="nav-link" name="Week" style="color: #565656; display:inline-block; float: none;">Nächste Woche</a>
  <a id="2" class="nav-link" name="Week" style="color: #565656; display:inline-block; float: none;">Übernächste Woche</a>
  </nav>
</div>
</div>
  <div class="swiper">
      <div id="card-container" class="swiper-wrapper">
        </div>  
    </div>
</div>
<script src="Ajax/JS/menu.js"></script>