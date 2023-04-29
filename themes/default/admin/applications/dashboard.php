<?php 
global $el;
global $conf;
global $apps;
use framework\core\libs\common\handler as Handler;

$apps = "";
$appNames = array();
if (!isset($_GET["route"])) {
}
$apps = new ApplicationModule();
$apps->init();
foreach ($apps->getApp() as $key) {
	array_push($appNames,trim($key));
}

// echo json_encode($apps->getAppInfo());
$appinfo = [];
foreach (array_values($apps->getAppInfo()[0]) as $value) {
	$k=trim(strtolower(explode(':',$value)[0]));
	$v=trim(strtolower(explode(':',$value)[1]));
	array_push($appinfo,array($k=>$v));
}
$appdetails = array(
				'name'=>$appinfo[0]['name'],
				'app'=>$appinfo[1]['app'],
				'author'=>$appinfo[2]['author'],
				'website'=>$appinfo[3]['website'],
				'email'=>$appinfo[4]['email'],
				'number'=>$appinfo[5]['number'],
				'datecreated'=>$appinfo[6]['datecreated'],
				'method'=>$appinfo[7]['method'],
				'version'=>$appinfo[8]['version']
			);
 ?>
<style>
    .iqr {
        --fa-primary-color: var(--red); 
        --fa-secondary-color: var(--white);

    }
    .box {
    	border: 1px solid #888888;
    	border-radius: 20px;
    	
    }
    .app-icon {
    	width:150px;
    	height:150px;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		background-repeat: no-repeat;
		background-position: center center;
    	margin: 5px;
    }

	.floating  { 
	    animation-name: floating;
	    animation-duration: 3s;
	    animation-iteration-count: infinite;
	    animation-timing-function: ease-in-out;
	    margin-left: 30px;
	    margin-top: 5px;
	}
	 
	@keyframes floating {
	    0% { transform: translate(0,  0px); }
	    50%  { transform: translate(0, 15px); }
	    100%   { transform: translate(0, -0px); }   
	}
	a.install {
		text-decoration: none;
	}
	.hud {
		cursor: pointer ;
	    --bs-border-color: #000000;
	    position: relative;
	    border: none;
	    margin:5px;
    	padding:5px;
    	height: 200px;
    	width: 200px; float:left;

	}
	.hud:hover {
		animation: blink 0.03s 10 linear;
	}

	.hud-background {
		background-color: #b7b7b7;
	}


	@keyframes blink {
	  50% {
		--bs-border-color: --white;
	  }
	  100% {
		--bs-border-color: --red;
	  }
	}


	.hud  > .app-icon {
    	font-size: 20pt;
    	padding: 10px;
    }
</style> 
<center>
	<?php 

	// echo $appinfo;
	 ?>
<?php if (isset($_GET['install'])) : ?>
<?php 
	if ($_GET['install'] == "true") {
		$appcode = $_GET['appcode'];
		$appname = $_GET['appname'];
		
		R::selectDatabase('INSTALLEDAPPS');

		$appupdate = R::dispense('apps');
		$appupdate->objid = "APP:".md5($appcode.uniqid());
		$appupdate->appcode = $appcode;
		$appupdate->appname = $appname;
		$appupdate->author = $appdetails['author'];
		$appupdate->auth = null;
		$appupdate->auth = null;
		$appupdate->token = null;
		$appupdate->email = $appdetails['email'];
		$appupdate->api = null;
		$appupdate->contactno = $appdetails['number'];
		$appupdate->dtcreated = date("m/d/Y h:i:s a");
		$appupdate->dtupdated = date("m/d/Y h:i:s a");;
		$appupdate->dtinstalled = date("m/d/Y h:i:s a");;
		$appupdate->method = $appdetails['method'];
		$appupdate->version = $appdetails['version'];
		$appupdate->website = $appdetails['website'];
		R::store( $appupdate );
		R::close();
	}else{
		R::selectDatabase('INSTALLEDAPPS');
		$recordID = isset($_GET['id'])? trim($_GET['id']):"";
		$appunst = R::load( 'apps', $recordID );
		R::trash( $appunst  );
		R::close();
	}

?>
<script>
	window.location.href = "?route=admin&page=applications";
</script>		
<?php endif ?>    	
<section>
	    <div style="display: inline-block; line-height: 12pt;">
	        	<?php $apID = 0; foreach($apps->getAppName() as $key): ?>
	        			<?php 
	        				$label = "INSTALL";
	        				$installed = "true"; 
	        				$installedApp = $apps->GetInstalledApp($appNames[$apID]);
	        				$updateID = "";
	        				if (count($installedApp) > 0) {
	        					// echo json_encode($installedApp);
	        					// echo $appNames[$apID];
	        					if ($installedApp[0]["appcode"] == $appNames[$apID]) {
	        						$label = "UNINSTALL";
	        						$installed = "false";
	        						$updateID = "&id=".$installedApp[0]["id"];
	        					}else{
	        						$label = "INSTALL";
	        						$installed = "true";
	        						$updateID = "";
	        					}
	        				}

	        			 ?>

		        		<div class="hud" style="margin-bottom: 50px;">
		        			<div class="hud-background"></div>
		        			<div class="hud-body">
								<div class="app-icon" style="background-image:url(apps/<?php echo $appNames[$apID]; ?>/icon.png);"></div>
							    <p class="name"><?php echo $key; ?></p>
							    <br>
							    <a class="install" href="?route=admin&page=applications&appcode=<?php echo trim($appNames[$apID]); ?><?php echo $updateID; ?>&install=<?php echo $installed; ?>&appname=<?php echo trim($key); ?>" ><?php echo $label; ?></a>

		        			</div>
		        			<div class="hud-arrow">
								<div class="hud-arrow-top-left"></div>
								<div class="hud-arrow-top-right"></div>
								<div class="hud-arrow-bottom-left"></div>
								<div class="hud-arrow-bottom-right"></div>
							</div>
						</div>
	        		<?php $apID++; ?>
	        	<?php endforeach ?>
	        	<?php 

	        	 // var_dump(get_declared_classes());
	        	 ?>
	    </div>
</section>
</center>