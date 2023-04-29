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

$token = new NameTokenizer();
$registry = new RegistryModel();
R::selectDatabase('SOCIALENTITY');

$method = isset($_POST['method']) ? trim($_POST['method']) : "" ; 
$search = isset($_POST['search']) ? str_replace('-', '', trim($_POST['search']))  : "" ; 
$result = $registry->getEntityByUnknownSingle(trim($search));
$hitCount = 0;
$notes = "";

if (isset($_COOKIE['_uid'])) {
    $id = $_COOKIE['_uid'];
    $object =  GetEntityProfile($id)["objid"];
    $profile =  GetEntityProfile($id);
    $role = json_decode($token->FormName(GetAccountSystemsProfile($object)['role'],"decrypt"));
}

echo "Searching: <b><u>". ucwords($search) ."</u></b>, <b><u><span id=\"hit\"></span></b></u><span id=\"notes\"></span>";
 ?>
<?php 
  $rank = [];
  $highHit = [];
  $midHit = [];
  $lowHit = [];
  $lessHit = [];
  foreach ($result as $hit) {
    if ( $hit['first_name'] != "" && str_replace('-', '', $hit['last_name'])  ) {
      $fullname =  str_replace('-', '', $hit['last_name']) . ", " . $hit['first_name'] . " " . $hit['middle_name'] . (isset($hit['suffix']) && $hit['suffix'] != ""? ", " . $hit['suffix']:"");
    }else if($hit['fullname_last'] != ""){
      $fullname =  str_replace('-', '', $hit['fullname_last']);
    }else if($hit['fullname_first'] != ""){
      $fullname =  str_replace('-', '', $hit['fullname_first']);
    }
    $matchPercentage = $fuzz->tokenSetRatio(strtoupper($search), strtoupper($fullname));
    $similarity = $fuzz->tokenSetRatio(strtoupper($search), strtoupper(str_replace('-', '', $hit['last_name'])));
    if ($matchPercentage > 50) {
      if ($similarity > 90) {
        $highHit[] = $hit;
      }else{
        $midHit[] = $hit;
      }
    }else{
      $lowHit[] = $hit;
    }
    array_push($rank, array("rank"=>$matchPercentage,"data"=>$hit));
  }
  $hits = array_merge($highHit,$midHit,$lowHit);
  arsort($rank);
  // echo json_encode($rank);
  // die();
 ?>
<?php foreach ($rank as $profile): ?>
  <?php 

    if ( $profile['data']['first_name'] != "" && str_replace('-', '', $profile['data']['last_name'])  ) {
      $fullname =  str_replace('-', '', $profile['data']['last_name']) . ", " . $profile['data']['first_name'] . " " . $profile['data']['middle_name'] . (isset($profile['data']['suffix']) && $profile['data']['suffix'] != ""? ", " . $profile['data']['suffix']:"");
      $ofullname =  $profile['data']['last_name'] . ", " . $profile['data']['first_name'] . " " . $profile['data']['middle_name'] . (isset($profile['data']['suffix']) && $profile['data']['suffix'] != ""? ", " . $profile['data']['suffix']:"");
    }else if($profile['data']['fullname_last'] != ""){
      $fullname =  str_replace('-', '', $profile['data']['fullname_last']);
      $ofullname =   $profile['data']['fullname_last'];
    }else if($profile['data']['fullname_first'] != ""){
      $fullname =  str_replace('-', '', $profile['data']['fullname_first']);
      $ofullname =  $profile['data']['fullname_first'];
    }

    // $fullname =  $profile['data']['last_name'] . ", " . $profile['data']['first_name'] . " " . $profile['data']['middle_name'] . (isset($profile['data']['suffix']) && $profile['data']['suffix'] != ""? ", " . $profile['data']['suffix']:"");
    $probability = $fuzz->tokenSetRatio(strtoupper($search), strtoupper($fullname));
    $colorClass = "border-primary bg-light";
    $hasClaimed = "border-primary bg-light";
    $iconClass = "";
    if ($probability > 85) {
      $iconClass = "fa-fade";
      $colorClass = "text-dark bg-yellow-1 border-danger";
    }else{
      $iconClass = "";
      $colorClass = "text-dark border-dark  bg-light";
    }
   ?>
      <?php if ($profile['rank'] >= 35): ?>
        <?php 
            $hitCount +=1;
            $notes = "in high probability";
         ?>
        

          <?php if (($profile['data']['txncode'] == 0 && $profile['data']['txnstatus'] != "VALIDATED") && is_null($profile['data']['txncode']) && $profile['data']['hasclaimed'] != 1 ): ?>
            <div class="card <?=$colorClass; ?> mb-3 " style="">
              <div class="card-header <?=$colorClass; ?>" style="display: inline;">
                
                <span>Payroll Code: <b><u><?= $profile['data']['payroll']; ?></u></b></span>
                <span style="position: absolute; right: 0; padding-right:20px;"> 
                  <?= ucwords(strtolower($profile['data']['citymun'])); ?> Teller: <b><u><?= $profile['data']['teller']; ?></u></b>
                </span> 
              </div>
              <div class="card-body" style="margin-top: -10px;">
                <h5 class="card-title"><?= $ofullname; ?></h5>
                <p>Match: <b><u><?= number_format($probability,2,'.',','); ?>%</u></b></p>
                <p class="card-text">Address: <b><u><?= ucwords(strtolower($profile['data']['barangay'])); ?></u></b>, <?= ucwords(strtolower($profile['data']['citymun'])); ?> </p>
                <span>Batch: <b><u><?= $profile['data']['batch']; ?></u></b> </span>
              </div>
              <?php if ( $role == 99): ?>        
                <span style="position: absolute; right: 10px; bottom: 0; font-size: 35pt;">
                  <a href="?ds=api&method=update&action=verified&objid=<?=$profile['data']['id'];?>'"  id='validate'>
                    <i class="fad fa-plus-circle <?=$iconClass;?> orange-accent"></i>
                  </a>
                </span>
              <?php endif ?>
            </div>
          <?php else: ?>
            <div class="card bg-orange-1 border-danger mb-3" style="">
              <div class="card-header bg-orange-1 border-danger" style="display: inline;">
                <span>Payroll Code: <b><u><?= $profile['data']['payroll']; ?></u></b></span>
                <span style="position: absolute; right: 0; padding-right:20px;"> 
                 Teller: <b><u><?= $profile['data']['teller']; ?></u></b>
                </span> 
              </span>
              </div>
              <div class="card-body" style="margin-top: -10px;">
                <h5 class="card-title"><?= $fullname; ?></h5> 


                <p>Match: <b><u><?= number_format($probability,2,'.',','); ?>%</u></b></p>
                <p class="card-text">Address: <b><u><?= ucwords(strtolower($profile['data']['barangay'])); ?></u></b>, <?= ucwords(strtolower($profile['data']['citymun'])); ?> </p>
                  <?php if ($profile['data']['hasclaimed'] == 1): ?>
                    <span style="background-color: yellow; padding:5px; border-radius: 5px; color: #505050; font-weight: 900;">CLAIMED</span>
                  <?php endif ?>
                  <span>Batch: <b><u><?= $profile['data']['batch']; ?></u></b> </span>
              </div>
              <span style="position: absolute; right: 10px; bottom: 0; font-size: 35pt; color:white;">
                  <i class="fad fa-check <?=$iconClass;?>"></i>
              </span>
            </div>
          <?php endif ?>
      <?php endif ?>    
<?php endforeach ?>
<script>

  $("#hit").text("<?=$hitCount==0?'':$hitCount; ?>");
  $("#notes").text(" <?=$notes; ?>");

</script>