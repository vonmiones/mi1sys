<?php 
global $registry;
global $redis;

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
R::selectDatabase('HOSPITAL');

$method = isset($_POST['method']) ? trim($_POST['method']) : "" ; 
$search = isset($_POST['search']) ?  trim($_POST['search'])  : "" ; 
$sensitivity = isset($_POST['sensitivity']) ? $_POST['sensitivity']  : 75 ; 

$list = $redis->keys("*");
$matchKey = []; 
if (isset($list) && count($list) > 0) {
  foreach ($list as $key) {
    if (findWord(strtolower($search),strtolower(substr($key,2)))) {
      array_push($matchKey, strtolower(substr($key,2)));
    }

  }
}
// die();
$keyresult = isset($matchKey) && count($matchKey) > 0 ? $matchKey[0] : $search ; 
$matchPercentage = $fuzz->tokenSetRatio(strtoupper($search), strtoupper($fullname));
$initResult = $registry->getEntityByID(trim($search),$keyresult);
$result = [];
$resultType = "";

switch ($initResult["source"]) {
  case 'cache':
      $result = $initResult["data"];
      $resultType = "c";
    break;
  default:
      $result = $initResult["data"];
      $resultType = "r";
    break;
}

$hitCount = 0;
$notes = "";

if (isset($_COOKIE['_uid'])) {
    $id = $_COOKIE['_uid'];
    $object =  GetEntityProfile($id)["objid"];
    $profile =  GetEntityProfile($id);
    $role = json_decode($token->FormName(GetAccountSystemsProfile($object)['role'],"decrypt"));
}
echo "Searching: <b><u>". ucwords($search) ."</u></b>,<span> </span><b style=\"margin-left:20px;\"><u><span id=\"hit\"></span></b></u><span id=\"notes\"></span>";

 ?>
<?php 
  $rank = [];
  $highHit = [];
  $midHit = [];
  $lowHit = [];
  $lessHit = [];
  foreach ($result as $hit) {
    if ( $hit['patfirst'] != "" && str_replace('-', '', $hit['patlast'])  ) {
      $fullname =  str_replace('-', '', $hit['patlast']) . ", " . $hit['patfirst'] . " " . $hit['patmiddle'] . (isset($hit['patsuffix']) && $hit['patsuffix'] != ""? ", " . $hit['patsuffix']:"");
    }else if($hit['fullname_last'] != ""){
      $fullname =  str_replace('-', '', $hit['fullname_last']);
    }else if($hit['fullname_first'] != ""){
      $fullname =  str_replace('-', '', $hit['fullname_first']);
    }else if($hit['hpercode'] != ""){
      $fullname =  str_replace('-', '', $hit['hpercode']);
    }
    $matchPercentage = $fuzz->tokenSetRatio(strtoupper($search), strtoupper($fullname));
    $similarity = $fuzz->tokenSetRatio(strtoupper($search), strtoupper(str_replace('-', '', $hit['patlast'])));
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

  $filteredResult = [];
 ?>
<?php foreach ($rank as $profile): ?>
  <?php 
    if ( $profile['data']['patfirst'] != "" && str_replace('-', '', $profile['data']['patlast'])  ) {
      $fullname =  str_replace('-', '', $profile['data']['patlast']) . ", " . $profile['data']['patfirst'] . " " . $profile['data']['patmiddle'] . (isset($profile['data']['patsuffix']) && $profile['data']['patsuffix'] != ""? ", " . $profile['data']['patsuffix']:"");
      $ofullname =  "<span style=\"font-weight:bold; text-decoration:underline; color:#ee5500;\">".$profile['data']['patlast'] . "</span>, " . $profile['data']['patfirst'] . " " . $profile['data']['patmiddle'] . (isset($profile['data']['patsuffix']) && $profile['data']['patsuffix'] != ""? ", " . $profile['data']['patsuffix']:"");
    }

    // $fullname =  $profile['data']['patlast'] . ", " . $profile['data']['patfirst'] . " " . $profile['data']['patmiddle'] . (isset($profile['data']['patsuffix']) && $profile['data']['patsuffix'] != ""? ", " . $profile['data']['patsuffix']:"");
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
      <?php if ($profile['rank'] >= $sensitivity): ?>
        <?php 
            $hitCount +=1;
            $notes = "in high probability";
            array_push($filteredResult,$profile['data']);

            $firstPersonnel = $registry->getPersonnelyID( trim($profile['data']['entryby']))[0];
            $fpFullname = $firstPersonnel['empprefix'] . " " . $firstPersonnel['firstname'] . ' ' . $firstPersonnel['lastname'];

            // die(json_encode($firstPersonnel));


            $hpercode = $profile['data']['hpercode'];
            
            $father = $profile['data']['fatlast'].", ".$profile['data']['fatfirst']." ".$profile['data']['fatmid'];
            $mother = $profile['data']['motlast'].", ".$profile['data']['motfirst']." ".$profile['data']['motmid'];

            $address = $profile['data']['spaddr'];
            $fataddress = $profile['data']['fataddr'];
            $motaddress = $profile['data']['motaddr'];

            $sex = $profile['data']['patsex'] == "M"?"Male":"Female";

            $bate = new DateTime($profile['data']['patbdate']);
            $admitResult = $registry->getAdmissionByID(trim($hpercode));
            $opdResult = $registry->getOPDConsultationByID(trim($hpercode));

            $lastAdmission = date('M d, Y h:i a', strtotime($registry->getAdmissionByID(trim($hpercode))[0]['admdate']));

            $lastAdmit = isset($admitResult) && count( $admitResult) > 0 ? date('M d, Y h:i a', strtotime($admitResult[0]['admdate'])) : "NO ADMISSION RECORD";
            $lastOPD = isset($opdResult) && count( $opdResult) > 0 ? date('M d, Y h:i a', strtotime($opdResult[0]['opddate'])) : "NO OPD RECORD";
            
            $now = new DateTime();
            $bday = $now->diff($bate);


         ?>
            <div class="card border-info mb-3" style="">
              <div class="card-header" style="display: inline;">
                <span class="bg-yellow-1" style="padding:5px; border-radius: 5px; color: #222;">Hospital ID: <b style="color: black; font-weight: 900;"><?= $profile['data']['hpercode']; ?></b></span>
                <span style=""> 
                  <span class="bg-orange-1 border-danger" style="padding:5px;  margin-right:5px; border-radius: 5px; color: #eeeeee;">
                  Admission: <b><u><?= $lastAdmit; ?></u></b>
                  </span>
                  <span class="bg-blue-1" style="padding:5px; margin-right:5px; border-radius: 5px; color: #FFFFFF;">
                  OPD: <b><u><?= $lastOPD; ?></u></b>
                  </span>
                  <span class="bg-green-1" style="padding:5px; border-radius: 5px; color: #FFFFFF;">
                  Entry By: <b><u><?= $fpFullname; ?></u></b>
                  </span>
                </span> 
              </span>
              </div>
              <div class="card-body" style="margin-top: -10px;">
                <div class="card-title" style="margin-bottom:0;"><?= $ofullname; ?></div> 
                <div class="card-text">
                  <div class="container" style="margin-left:-20px;">
                    <div class="row"> 
                      <div style="width:100px;">Age: <?= ucwords(strtolower($bday->y)); ?></div>
                      <div style="width:150px;">Sex: <?= ucwords(strtolower($sex)); ?></div>
                      <div class="col">Address: <?= ucwords(strtolower($address)); ?></div>
                    </div>
                    <div class="row"> 
                      <div style="width:400px;">Father's Name: <?= ucwords(strtolower($father)); ?></div>
                      <div class="col">Address: <?= ucwords(strtolower($fataddress)); ?></div>
                    </div>
                    <div class="row"> 
                      <div style="width:400px;">Mother's Name: <?= ucwords(strtolower($mother)); ?></div>
                      <div class="col">Address: <?= ucwords(strtolower($motaddress)); ?></div>
                    </div>
                    <div>
                      <?php 
                        echo "result for:  $hpercode<br>";
                        // echo json_encode();
                       ?>
                    </div>
                  </div>
                    
                  </div>
              </div>
              <span style="position: absolute; right: 10px; bottom: 0; font-size: 35pt; color:white;">
                  <i class="fad fa-check <?=$iconClass;?>"></i>
              </span>
            </div>
      
      <?php endif ?>    
<?php endforeach ?>
<?php 
  if ($resultType == "r") {
    $redis->set( 'q_' . strtolower($keyresult), json_encode($filteredResult));
  }
 ?>
<script>

  $("#hit").text("<?=$hitCount==0?'':$hitCount; ?>");
  $("#notes").text(" <?=$notes; ?>");

</script>