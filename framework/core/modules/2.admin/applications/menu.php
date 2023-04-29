<!-- Module Menu Start -->
<nav class="navbar navbar-expand-lg" style="border-bottom:1px solid ; border-bottom-color: grey;">
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <div class="dropdown">
        <a class="nav-item nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa-duotone fa-album-collection"></i> Entities
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <a class="nav-item nav-link" href="?route=admin&page=account&fn=manage.entities"><i class="fa-duotone fa-poll-people"></i> Manage Entities</a>
          <a class="nav-item nav-link" href="?route=admin&page=account&fn=register.entity"><i class="fa-duotone fa-address-card"></i> Add Entity</a>
        </div>
      </div>
      <div class="dropdown">
        <a class="nav-item nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa-duotone fa-users-gear"></i>  User Accounts
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <a class="nav-item nav-link" href="?route=admin&page=account&fn=register.user"><i class="fa-duotone fa-user-plus"></i> Create User</a>
          <a class="nav-item nav-link" href="?route=admin&page=account&fn=manage.user"><i class="fa-duotone fa-screen-users"></i> Manage Users</a>
          <a class="nav-item nav-link" href="?route=admin&page=account&fn=register.user"><i class="fa-duotone fa-users"></i> User Groups</a>
        </div>
      </div>      
      
      <a class="nav-item nav-link" href="?route=admin&page=account&fn=roles"><i class="fa-duotone fa-shield-keyhole"></i> Roles and Permissions</a>
    </div>
  </div>
  <span class="form-inline">
      <button class="btn btn-primary" style="margin-right:10px;" type="button">Save</button> 
      <button class="btn btn-primary" style="margin-right:10px;" type="button">Clear</button>
  </span>
</nav>
<!-- Module Menu End -->
<!-- MODAL START -->
 <div class="modal fade" role="dialog" tabindex="-1" id="toolModal" style="min-width: 800;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div id="toolbox"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" id="btn-close" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="btn-save" type="button">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL END -->