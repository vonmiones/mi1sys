<?php
$apps = "";
$appNames = array();
$token = new NameTokenizer();
if (!isset($_GET["route"])) {
	$apps = new ApplicationModule();
	$apps->init();
	foreach ($apps->getApp() as $key) {
		array_push($appNames,trim($key));
	}
}
?>
<?php if (count($appNames)>0 && (!isset($_GET["app"]))): ?>
<?php if (!isset($_COOKIE['app'])): ?>
	<html>
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	    <title>Dashboard - Brand</title>
	    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/bootstrap/css/bootstrap.min.css">
	    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/DataTables/datatables.min.css">
	    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/css/default.css">
	    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/css/hud.css">
	    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/fontawesome/css/fontawesome.min.css">
	    <link rel="stylesheet" href="themes/<?= TEMPLATE; ?>/assets/fontawesome/css/duotone.min.css">
	    <script src="themes/<?= TEMPLATE; ?>/assets/js/jquery.min.js"></script>
	    <script src="themes/<?= TEMPLATE; ?>/assets/bootstrap/js/bootstrap.min.js"></script>
	    <script src="themes/<?= TEMPLATE; ?>/assets/DataTables/datatables.min.js"></script>
	    <style>
	        .iqr {
	            --fa-primary-color: var(--red); 
	            --fa-secondary-color: var(--white);

	        }
	        .box {
	        	border: 1px solid #888888;
	        	border-radius: 20px;
	        	margin:5px;
	        	padding:5px;
	        	height: 150px;
	        	width: 150px; float:left;
	        }
	        .box  > .icon {
	        	font-size: 20pt;
	        	padding: 10px;
	        }
	        .app-icon {
	        	width:100px;
	        	height:100px;
	        	background-size: contain;
	        	background-position: center center;
	        	background-repeat: no-repeat;
	        	margin: 5px;
	        }
			.hud {
				cursor: pointer ;
			    --bs-border-color: #000000;
			    position: relative;
			    border: none;
			    margin:5px;
		    	padding:5px;
		    	min-height: 150px;
		    	min-width: 150px; 
		    	float:left;

			}

			.hud-background {
				background-color: #aaaaaa;
			}


			.hud  > .app-icon {
		    	font-size: 20pt;
		    	padding: 10px;
		    }
		    audio {
			    position: absolute;
			    left: -110%;
			    top: -10px;
			    display: block;
			    height: 30px;
			    width: 200px;
			}
	    </style>
	</head>

	<body id="page-top">
	<section>
	    <center>    	
		    <div style="display: inline-block; margin-top:15%; line-height: 12pt;">
		    	<?php 
			    	$appcreds = "";
			    	if (isset($_COOKIE['_uid'])) {
			    		$id = $_COOKIE['_uid'];
	                    $object =  GetEntityProfile($id)["objid"];
	                    // $profile =  GetEntityProfile($id);
	                    $allowedApps = json_decode($token->FormName(GetAccountSystemsProfile($object)['appids'],"decrypt"));
	                }
                    R::selectDatabase('INSTALLEDAPPS');
                    $apps = R::getAll( 'SELECT * FROM apps' );
                 ?>		    	 
		        	<?php $apID = 0; foreach($apps as $key): ?>

		        			<?php foreach ($allowedApps as $appkey): ?>
		        				<?php if ($key['id'] == $appkey ): ?>  					
				        		<a onmouseenter="ha(this)" href="?app=<?php echo $key['appcode']; ?>" id="app-link" class="floating">
									<div class="hud">
										<div class="hud-background"></div>
										<div class="hud-body">
											<div class="app-icon" style="background-image:url(apps/<?php echo $key['appcode']; ?>/icon.png);"></div>
										    <p class="name"><?php echo $key["appname"]; ?></p>
										</div>
										<div class="hud-arrow">
											<div class="hud-arrow-top-left"></div>
											<div class="hud-arrow-top-right"></div>
											<div class="hud-arrow-bottom-left"></div>
											<div class="hud-arrow-bottom-right"></div>
										</div>
										<audio  id="uia" style="display:none;" controls preload="true">
											<source src="themes/<?= TEMPLATE; ?>/assets/ui/audio/ui-select-2.mp3" controls></source>
										</audio>
									</div>
								</a>
		        				<?php endif ?>	        				
		        			<?php endforeach ?>

		        		<?php $apID++; ?>
		        	<?php endforeach ?>
		        <?php 
		        	// R::close();
		         ?>
		    </div>
	    </center>

	</section>
	<script>
		function ha(el){
			var ua = $("#uia",el);
			ua[0].play();
			// console.log($("#uia",el));
		}
	</script>	
	    <script src="themes/<?= TEMPLATE; ?>/assets/fontawesome/js/fontawesome.min.js"></script>
	    <script src="themes/<?= TEMPLATE; ?>/assets/fontawesome/js/duotone.min.js"></script>
	    <script src="themes/<?= TEMPLATE; ?>/assets/js/chart.min.js"></script>
	    <script src="themes/<?= TEMPLATE; ?>/assets/js/bs-init.js"></script>
	    <script src="themes/<?= TEMPLATE; ?>/assets/js/jquery.easing.js"></script>
	    <script src="themes/<?= TEMPLATE; ?>/assets/js/theme.js"></script>
	</body>

	</html>

<?php endif ?>
<?php endif ?>
<?php	


if (isset($_GET["app"])) {
	if ($_GET["app"] != "") {
			setcookie("app", $_GET["app"]);
			header("location:index.php");
	}
}
if (isset($_COOKIE['app'])) {
			if (isset($_GET["route"])) {
				$apps = new ApplicationModule();
			}else{
				$appName =  "mi1_apps_".$_COOKIE['app'];
				$app = new $appName();		
			}
}