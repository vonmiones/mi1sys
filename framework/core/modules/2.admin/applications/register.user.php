<style>
    #page-user {
        margin-top: 30px;
    }
    .form-info{
      width:450px;
      font-size: 9pt;
    }
</style>
<div class="container" id="page-user">
    <div class="d-md-flex align-content-center align-self-center flex-wrap justify-content-md-center" style="text-align: left;margin: 0 auto;">
        <?php 
        $empID = isset($_POST["id"])? $_POST["id"]:"";

        GetEntities();

        ?>
        <form class="password-strength form p-4">
            <section>
              <label>Username<input type="text" class="form-control" /></label>
              <label>Email<input type="text" class="form-control" /></label></section>
            <section>
              <label>Password<input class="password-strength__input form-control" type="password" id="password-input" aria-describedby="passwordHelp" placeholder="Enter password" />
              </label>
              <label>
                  User Group
                  <select class="form-control" name="namesuffix">
                      <option value>None</option>
                      <optgroup label="User Group">
                          <option value="1">User</option>
                          <option value="1">Member</option>
                          <option value="1">Editor</option>
                          <option value="1">Contributor</option>
                      </optgroup>
                      <optgroup label="Administrator Group">
                          <option value="1">User Administrator</option>
                          <option value="1">Apps Administrator</option>
                          <option value="1">DB Administrator</option>
                      </optgroup>
                      <optgroup label="Developer Group">
                          <option value="1">Developer</option>
                          <option value="1">Super Administrator</option>
                      </optgroup>
                  </select>
              </label>
            </section>
            <section><label>Password Strength</label>
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
