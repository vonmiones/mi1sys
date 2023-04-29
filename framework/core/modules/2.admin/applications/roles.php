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
<div class="container">
    <div class="d-md-flex flex-wrap" style="text-align: left;margin: 0 auto;">
        <form>
            <section>
                <div style="float:left;" class="list-containers">                
                    <fieldset>
                        <legend>Roles</legend>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="radio" name="role" value="" placeholder=""> Blocked</span> <span class="badge badge-primary badge-pill">14</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="radio" name="role" value="" placeholder=""> Banned</span> <span class="badge badge-primary badge-pill">14</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="radio" name="role" value="" placeholder=""> Guest</span> <span class="badge badge-primary badge-pill">14</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="radio" name="role" value="" placeholder=""> Normal User</span> <span class="badge badge-primary badge-pill">14</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="radio" name="role" value="" placeholder=""> Moderator</span> <span class="badge badge-primary badge-pill">14</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="radio" name="role" value="" placeholder=""> Administrator</span> <span class="badge badge-primary badge-pill">14</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="radio" name="role" value="" placeholder=""> Super Administrator</span> <span class="badge badge-primary badge-pill">14</span></li>
                        </ul>
                    </fieldset>
                </div>
                <div style="float:left;" class="list-containers">                
                    <fieldset>
                        <legend>Apps</legend>
                        <ul class="list-group">
                            <?php 
                                R::addDatabase('INSTALLEDAPPS','mysql:host='.SYSTEMDBHOST.';dbname='.SYSTEMDBNAME.'_apps',SYSTEMDBUSER, SYSTEMDBPASS );
                                R::close();
                                R::selectDatabase('INSTALLEDAPPS');
                                $apps = R::getAll( 'SELECT * FROM apps' );
                             ?>
                             <?php foreach ($apps as $app): ?>                             
                                <li class="list-group-item d-flex justify-content-between align-items-center"><span> <input type="checkbox" name="apps[]" value=""><?php echo $app["app_name"]; ?></span> <span class="badge badge-primary badge-pill">14</span></li>
                             <?php endforeach ?>
                        </ul>
                    </fieldset>
                </div>
            </section>
        </form>
    </div>
</div>