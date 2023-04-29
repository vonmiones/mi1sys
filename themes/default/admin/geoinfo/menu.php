<style>
  .region{
    color: red;
  }
  .province{
    color: orange;
  }
  .municipality{
    color: green;
  }
  .barangay{
    color: blue;
  }
</style>
<!-- Module Menu Start -->
<nav class="navbar navbar-expand-lg" style="border-bottom:1px solid ; border-bottom-color: grey;">
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <div class="dropdown">
        <a class="dropdown-toggle nav-link" href="#" role="button" id="dropdownMenuLink"  aria-expanded="false" data-bs-toggle="dropdown">
          <i class="fa-duotone fa-map-location"></i> Address Management
        </a>
        <div class="dropdown-menu shadow dropdown-menu-start animated--grow-in" aria-labelledby="dropdownMenuLink">
          <a class="nav-item nav-link" href="?route=admin&page=geoinfo&fn=manage.region"><i class="fa-duotone fa-location-dot region"></i> Regions</a>
          <a class="nav-item nav-link" href="?route=admin&page=geoinfo&fn=manage.provinces"><i class="fa-duotone fa-location-dot province"></i> Provinces</a>
          <a class="nav-item nav-link" href="?route=admin&page=geoinfo&fn=manage.citymunicipalities"><i class="fa-duotone fa-location-dot municipality"></i> City Municipality</a>
          <a class="nav-item nav-link" href="?route=admin&page=geoinfo&fn=manage.barangays"><i class="fa-duotone fa-location-dot barangay"></i> Barangay</a>
        </div>
      </div>
      <a class="nav-item nav-link" href="?route=admin&page=geoinfo&fn=view.apis"><i class="fa-duotone fa-anchor"></i> API</a>
    </div>
  </div>
  <span class="form-inline">
      <button class="btn btn-primary" style="margin-right:10px;" type="button">Save</button> 
      <button class="btn btn-primary" style="margin-right:10px;" type="button">Clear</button>
  </span>
</nav>
<!-- Module Menu End -->