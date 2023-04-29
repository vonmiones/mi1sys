<?php 
$currentFn = isset($_GET["fn"])? $_GET["fn"] : "";

 ?>
<!-- Module Menu Start -->
<nav class="navbar navbar-expand-lg" style="border-bottom:1px solid ; border-bottom-color: grey;">
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <div class="dropdown">
        <a class="dropdown-toggle nav-link" href="#" role="button" id="dropdownMenuLink"  aria-expanded="false" data-bs-toggle="dropdown">
          <i class="fa-duotone orange-accent fa-album-collection"></i> Entities
        </a>

        <div class="dropdown-menu shadow dropdown-menu-start animated--grow-in" aria-labelledby="dropdownMenuLink">
          <a class="nav-item nav-link" href="?route=admin&page=account&fn=manage.entities"><i class="fa-duotone orange-accent fa-poll-people"></i> Manage Entities</a>
          <a class="nav-item nav-link" href="?route=admin&page=account&fn=register.entity"><i class="fa-duotone orange-accent fa-address-card"></i> Add Entity</a>
        </div>
      </div>      
      <a class="nav-item nav-link" href="?route=admin&page=account&fn=roles"><i class="fa-duotone orange-accent fa-shield-keyhole"></i> Roles and Permissions</a>
    </div>
    <?php if ($currentFn == "register.entity"): ?>    
        <div class="navbar-right" style="position: absolute; right:0;">
            <button class="btn btn-primary password-strength__submit" id="btn-save" type="button">Save</button>
        </div>
    <?php endif ?>
  </div>
</nav>

<!-- Module Menu End -->
<!-- Modal Start -->
 <div class="modal fade" role="dialog" tabindex="-1" id="toolModal" style="min-width: 800;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="btn btn-primary" id="btn-print" type="button">Print</button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="toolbox"></div>
                <div id="elementH"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button"  data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button class="btn btn-primary password-strength__submit" id="btn-save" type="button">Save</button>
                <button class="btn btn-primary" id="btn-update" type="button">Update</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal End -->