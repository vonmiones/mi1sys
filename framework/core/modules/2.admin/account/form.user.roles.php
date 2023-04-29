<style>
    #page-user {
        margin-top: 30px;
    }
    .list-group li {
        height: 40px; 
        width: 250px;
        font-size: 12pt;
        padding: 10px 15px;
    }
    .list-containers {
        margin-left: 10px;
    }
</style>

<?php 

$view     = "";
$token = new NameTokenizer();

$activity = isset($_POST["activity"])?$_POST["activity"]:"";
$object = isset($_POST["object"])?  $token->FormName($_POST["object"],'decrypt'):"";
$fullName = isset($_POST["fullname"])? $_POST["fullname"]:"";
$firstname = isset($_POST["first"])? $_POST["first"]:"";
$middlename = isset($_POST["middle"])? $_POST["middle"]:"";
$lastname = isset($_POST["last"])? $_POST["last"]:"";
$pass = isset($_POST["pass"])? $_POST["pass"]:"";
$entity = isset($_POST["object"])? $_POST["object"]:"";
$email = isset($_POST["email"])? $_POST["email"]:"";
$access = true;

R::selectDatabase('LOGIN');
$logcreds=R::getRow( "SELECT * FROM accountlogin WHERE entity = '$object'" );
$appcreds=R::getAll( "SELECT * FROM accountsystems WHERE entity ='$object'");
$activeApps = [];
$message = "";

if (count($logcreds) == 0) {
    $access = false;
    $message =  "No account options available.";
}
 ?>

<div class="container">
    <div class="d-md-flex flex-wrap" style="text-align: left;margin: 0 auto;">
        <form>
            <h1><?php echo $fullName; ?></h1>
              <?php if ($object != ""): ?>
                  <input type="hidden" name="object" id="object" value="<?php echo $object; ?>">
                  <input type="hidden" name="fullname" id="fullname" value="<?php echo $fullName; ?>">
                  <input type="hidden" name="firstname" id="firstname" value="<?php echo $firstname; ?>">
                  <input type="hidden" name="middlename" id="middlename" value="<?php echo $middlename; ?>">
                  <input type="hidden" name="lastname" id="lastname" value="<?php echo $lastname; ?>">
                  <input type="hidden" name="passwd" id="passwd" value="<?php echo $password; ?>">
              <?php endif ?>
              <?php if (count($appcreds) > 0): ?>
               <input type="hidden" name="action" id="action" value="update">
              <?php else: ?>
               <input type="hidden" name="action" id="action" value="save">
              <?php endif ?>
            <script>
              var roleDefault = 0; 
              <?php if ($access == true): ?>
                      <?php if (count($appcreds) > 0): ?>
                          $("#btn-save").hide();
                          $("#btn-update").show();
                          roleDefault = <?php echo $appcreds['role']?$appcreds['role']:0; ?>;
                      <?php else: ?>
                          $("#btn-save").show();
                          $("#btn-update").hide();
                          roleDefault = 0;
                      <?php endif ?>
                        $(".radio-"+roleDefault).attr('checked', 'checked');
                  <?php else: ?>
                    $("#btn-save").hide();
                    $("#btn-update").hide();
                    
              <?php endif ?>
            </script>
            <?php 
                if ($access == false) {
                    die("$message"); 
                }
            ?>
            <section>
                <?php 
                    R::selectDatabase('INSTALLEDAPPS');
                    $apps = R::getAll( 'SELECT * FROM apps' );
                    $roleStatus = "";                  
                 ?>                
                <div style="float:left;" class="list-containers">                
                    <fieldset>
                        <legend>Roles</legend>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="radio" class="radio-0" id="selected-role" name="role" data-role="0" value="0"> Banned</span> <span class="badge badge-primary badge-pill">14</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="radio" class="radio-1" id="selected-role" name="role" data-role="1" value="1"> Blocked</span> <span class="badge badge-primary badge-pill">14</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="radio" class="radio-2" id="selected-role" name="role" data-role="2" value="2"> Guest</span> <span class="badge badge-primary badge-pill">14</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="radio" class="radio-3" id="selected-role" name="role" data-role="3" value="3"> Normal User</span> <span class="badge badge-primary badge-pill">14</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="radio" class="radio-50" id="selected-role" name="role" data-role="50" value="50"> Moderator</span> <span class="badge badge-primary badge-pill">14</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="radio" class="radio-90" id="selected-role" name="role" data-role="90" value="90"> Administrator</span> <span class="badge badge-primary badge-pill">14</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="radio" class="radio-99" id="selected-role" name="role" data-role="99" value="99"> Super Administrator</span> <span class="badge badge-primary badge-pill">14</span></li>
                        </ul>
                    </fieldset>
                </div>
                <div style="float:left;" class="list-containers">                
                    <fieldset>
                        <legend>Apps</legend>
                        <ul class="list-group">
                            <input type="hidden" name="entity" id="objid" value="<?= $object;?>">
                             <?php foreach ($apps as $app): ?>
                             <?php 
                                $itemStatus = "";
                                if (count($appcreds) > 0) {
                                  foreach($appcreds as $id) {
                                        foreach (json_decode($token->FormName($id['appids'],'decrypt')) as $tval) {
                                            if ($app["id"] == $tval) {
                                                $itemStatus = "checked";
                                            }
                                        }
                                    }  
                                }
                              ?>                         
                                <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input <?php echo $itemStatus; ?> type="checkbox" id="selected-app" name="apps[]" value="<?php echo $app["id"]; ?>" data-name="<?php echo $app["appname"]; ?>"> <?php echo $app["appname"]; ?></span> <span class="badge badge-primary badge-pill">14</span></li>
                             <?php endforeach ?>
                        </ul>
                    </fieldset>
                </div>
            </section>
        </form>
    </div>
</div>