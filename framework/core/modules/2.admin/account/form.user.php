<style>
    #page-user {
        margin-top: 30px;
    }
    .form-info{
      width:450px;
      font-size: 9pt;
    }
    .js-hidden {
      visibility: hidden;
    }
</style>
<div class="container" id="page-user">
    <div class="d-md-flex align-content-center align-self-center flex-wrap justify-content-md-center" style="text-align: left;margin: 0 auto;">
        <?php 

        $view     = "";
        $token = new NameTokenizer();
        $activity = isset($_POST["activity"])?$_POST["activity"]:"";
        $object = isset($_POST["object"])? $_POST["object"]:"";
        $fullName = isset($_POST["fullname"])? $_POST["fullname"]:"";
        $firstname = isset($_POST["first"])? $_POST["first"]:"";
        $middlename = isset($_POST["middle"])? $_POST["middle"]:"";
        $lastname = isset($_POST["last"])? $_POST["last"]:"";
        $pass = isset($_POST["pass"])? $_POST["pass"]:"";
        $entity = isset($_POST["object"])? $_POST["object"]:"";
        $email = isset($_POST["email"])? $_POST["email"]:"";
        $userval = isset($_POST["user"])? $_POST["user"]:"";

        GetEntities();
        // R::selectDatabase('LOGIN');
        // $logcreds=R::getRow( "SELECT * FROM accountlogin WHERE objid = '$object'" );  
        $logcreds=array_values(checkExistingAccount(array("object"=>$token->FormName($object,'decrypt'))));  

        ?>
        <form class="password-strength form p-4">
            <section>
              <h1><?php echo $fullName; ?></h1>
              <?php if ($object != ""): ?>
                  <input type="hidden" name="object" id="object" value="<?php echo $object; ?>">
                  <input type="hidden" name="fullname" id="fullname" value="<?php echo $fullName; ?>">
                  <input type="hidden" name="firstname" id="firstname" value="<?php echo $firstname; ?>">
                  <input type="hidden" name="middlename" id="middlename" value="<?php echo $middlename; ?>">
                  <input type="hidden" name="lastname" id="lastname" value="<?php echo $lastname; ?>">
                  <input type="hidden" name="pass" id="pass" value="<?php echo $pass; ?>">
              <?php endif ?>
              <?php
              if (count($logcreds) > 0) {
                $userval = $token->FormName($logcreds["user"],'decrypt');
                $email = $token->FormName($logcreds["email"],'decrypt');
                $view = "readonly";
              }else{
                $userval= strtoupper( substr( $firstname, 0,1).".".$lastname);
              }
               ?>
                <?php if (count($logcreds) > 0): ?>
                 <input type="hidden" name="action" id="action" value="update">
                <?php else: ?>
                 <input type="hidden" name="action" id="action" value="save">
                <?php endif ?>
              <script>
                <?php if (count($logcreds) > 0): ?>
                    $("#btn-save").hide();
                    $("#btn-update").show();
                <?php else: ?>
                    $("#btn-save").show();
                    $("#btn-update").hide();
                <?php endif ?>
              </script>

              <input type="hidden" id="id" class="form-control" value="<?php echo $entity; ?>" />
              <label>Username<input type="text" id="username" <?php echo $view; ?> class="form-control" value="<?php echo $userval; ?>" /></label>
              <label>Email<input type="text" id="email" class="form-control" value="<?php echo $email; ?>"/></label></section>
            <section>
              <label>Password<input id="password" class="password-strength__input form-control" type="password" id="password-input" aria-describedby="passwordHelp" placeholder="Enter password" />
              </label>
              <label>
                  User Group
                  <select class="form-control" name="accountroles" id="accountroles">
                      <option value>None</option>
                      <optgroup label="User Group">
                          <option value="1">User</option>
                          <option value="2">Member</option>
                          <option value="3">Editor</option>
                          <option value="4">Contributor</option>
                      </optgroup>
                      <optgroup label="Administrator Group">
                          <option value="10">User Administrator</option>
                          <option value="77">Apps Administrator</option>
                          <option value="88">DB Administrator</option>
                      </optgroup>
                      <optgroup label="Developer Group">
                          <option value="111">Developer</option>
                          <option value="888">Super Administrator</option>
                      </optgroup>
                  </select>
              </label>
            </section>
            <section>
              <i class="password-strength__visibility"></i>
              <label>Password Strength</label>
                <div class="password-strength__bar-block progress mb-4">
                    <div class="password-strength__bar progress-bar bg-danger" role="progressbar"  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
                <div class="form-info form-text password-strength__error text-danger js-hidden">This symbol is not allowed!</div>
                <div class="form-info form-text text-muted mt-2" id="passwordHelp">Add 9 charachters or more, lowercase letters, uppercase letters, numbers and symbols to make the password really strong!</div>
            </section>
        </form>
    </div>
</div>
<script src="themes/<?= TEMPLATE; ?>/assets/js/plugins/strength.js"></script>
