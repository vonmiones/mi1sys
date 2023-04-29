<?php 
global $registry;
include_once 'dashboard.controller.php';

use framework\core\libs\common\handler as Handler;
use framework\core\libs\database as Database;

$v = new Handler\Vendor();
$f = $v->getDBVendorFramework('framework/core/libs/database/*',"fuzzywuzzy.php");
include_once "$f";
new Database\FuzzyMatch();

use FuzzyWuzzy\Fuzz;
use FuzzyWuzzy\Process;

$fuzz = new Fuzz();
$process = new Process($fuzz);


$registry = new RegistryModel();
R::selectDatabase('SOCIALENTITY');

$method = isset($_POST['method']) ? trim($_POST['method']) : "" ; 
$search = isset($_POST['search']) ? trim($_POST['search']) : "" ; 

$result = $registry->getEntityByUnknownSingle(trim($search));
echo "Searching: <b><u>". ucwords($search) ."</u></b> Found: <b><u>".count($result)."</u></b>";
 ?>
<?php 
  $ranked = [];
  // foreach ($result as $unsorted) {
  //   $fullname =  $profile['last_name'] . ", " . $profile['first_name'] . " " . $profile['middle_name'] . (isset($profile['suffix']) && $profile['suffix'] != ""? ", " . $profile['suffix']:"");
  //   $probability = $fuzz->ratio(strtoupper($search), strtoupper($fullname));
  // }

 ?>
<?php foreach ($result as $profile): ?>
  <?php 
    $fullname =  $profile['last_name'] . ", " . $profile['first_name'] . " " . $profile['middle_name'] . (isset($profile['suffix']) && $profile['suffix'] != ""? ", " . $profile['suffix']:"");
    $probability = $fuzz->tokenSetRatio(strtoupper($search), strtoupper($fullname));
    $colorClass = "border-primary bg-light";
    $iconClass = "";
    if ($probability > 85) {
      $iconClass = "fa-fade";
      $colorClass = "text-dark bg-warning border-danger";
    }else{
      $iconClass = "";
      $colorClass = "text-dark border-dark  bg-light";
    }

   ?>
      <div class="card <?=$colorClass; ?> mb-3 " style="">
        <div class="card-header <?=$colorClass; ?>" style="display: inline;"><span>Payroll Code: <b><u><?= $profile['payroll']; ?></u></b></span><span style="position: absolute; right: 0; padding-right:20px;"> Teller: <b><u><?= $profile['teller']; ?></u></b></span> </span>
        </div>
        <div class="card-body" style="margin-top: -10px;">
          <h5 class="card-title"><?= $fullname; ?></h5>
          <p>Audibility: <b><u><?= number_format($probability,2,'.',','); ?>%</u></b></p>
          <p class="card-text">Address: <b><u><?= ucwords(strtolower($profile['barangay'])); ?></u></b>, <?= ucwords(strtolower($profile['citymun'])); ?> </p>
        </div>
        <span style="position: absolute; right: 10px; bottom: 0; font-size: 35pt;">
          <a href="?ds=api&method=update&action=verified&objid=<?=$profile['id'];?>'"  id='validate'>
            <i class="fad fa-check-circle <?=$iconClass;?> orange-accent"></i>
          </a>
        </span>
      </div>
    <?php if ($probability > 70): ?>
    <?php endif ?>

<?php endforeach ?>

