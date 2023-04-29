<?php 
global $registry;
global $redis;
include_once 'dashboard.controller.php';
// include_once 'surname.php';

// die();


$speed = starttest();

function starttest()
{
  return microtime(true);
}
function endtest()
{
  return microtime(true);
}

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
if (preg_match("/\d{2}-\d{2}-\d{2}/", $search)) {
  $search = isset($_POST['search']) ? str_replace('-', '', trim($_POST['search']))  : "" ; 
}else{
  $search = isset($_POST['search']) ? trim($_POST['search'])  : "" ; 
}
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
// $keyresult = $search ;

$matchPercentage = $fuzz->tokenSetRatio(strtoupper($search), strtoupper($fullname));

if (preg_match("/\d{2}-\d{2}-\d{2}/", $search)) {
  $initResult = $registry->getEntityByID(trim($search));
}else{
  $initResult = $registry->getEntityByUnknownSingle(trim($search),$keyresult);
}

// xdebug_debug_zval($initResult);

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


echo ".:$resultType:. Searching: <b><u>". ucwords($search) ."</u></b>,<span> </span><b style=\"margin-left:20px;\"><u><span id=\"hit\"></span></b></u><span id=\"notes\"></span>";

 ?>
<?php 
  $rank = [];
  $highHit = [];
  $midHit = [];
  $lowHit = [];
  $lessHit = [];
  foreach ($result as $hit) {
    if (preg_match("/\d{2}-\d{2}-\d{2}/", $search)) {
      if($hit['hpercode'] != ""){
        $fullname = $hit['hpercode'];
      }
    }else{
      if ( $hit['patfirst'] != "" && str_replace('-', '', $hit['patlast'])  ) {

          switch (true) {
            case preg_match('/^([A-Z][a-z]+) (('.$hit['patfirst'].')( )?)?( (S\.)?)( ('.$hit['patlast'].')(, )?(Jr)?)?$/', $search):
                // code to execute for names that match pattern 1
                  $fullname = $hit['patfirst'].' '.$hit['patlast'].' '.$hit['patsuffix'];          
                  $pattern = "1";
                break;
            case preg_match('/^([A-Z][a-z]+) (('.$hit['patfirst'].')( )?)?( (S\.)?)( ('.$hit['patlast'].')(, Jr)?)?$/', $search):
                // code to execute for names that match pattern 2
                  $fullname =  $hit['patfirst'].' '.$hit['patlast'].', '.$hit['patsuffix'];          
                  $pattern = "2";
                break;
            case preg_match('/^([A-Z][a-z]+) (('.$hit['patfirst'].')( )?)?( (S\.)?)( ('.$hit['patlast'].') Jr)?$/', $search):
                // code to execute for names that match pattern 3
                  $fullname =  $hit['patfirst'].' '.$hit['patmiddle'].' '.$hit['patlast'];          
                  $pattern = "3";
                break;
            case preg_match('/^([A-Z][a-z]+) Sr (('.$hit['patfirst'].')( )?)?( (S\.)?)( ('.$hit['patlast'].')(, )?)?$/', $search):
                // code to execute for names that match pattern 4
                  $fullname =  $hit['patfirst'].' '.$hit['patmiddle'].' '.$hit['patlast'].', '.$hit['patsuffix'];          
                  $pattern = "4";
                break;
            case preg_match('/^([A-Z][a-z]+) III (('.$hit['patfirst'].')( )?)?( (S\.)?)( ('.$hit['patlast'].')(, )?)?$/', $search):
                // code to execute for names that match pattern 5
                  $fullname =  $hit['patfirst'].' '.substr($hit['patmiddle'],1).'. '.$hit['patlast'];          
                  $pattern = "5";
                break;
            case preg_match('/^'.$hit['patlast'].', ([A-Z][a-z]+) (('.$hit['patfirst'].')( )?)?( (S\.)?)?( Jr)?$/', $search):
                // code to execute for names that match pattern 6
                  $fullname =  $hit['patfirst'].' '.substr($hit['patmiddle'],1).'. '.$hit['patlast'].', '.$hit['patsuffix'];          
                  $pattern = "6";
                break;
            case preg_match('/^'.$hit['patlast'].', ([A-Z][a-z]+) Sr (('.$hit['patfirst'].')( )?)?( (S\.)?)?$/', $search):
                // code to execute for names that match pattern 7
                  $fullname =  $hit['patfirst'].' '.substr($hit['patmiddle'],1).'. '.$hit['patlast'].' '.$hit['patsuffix'];          
                  $pattern = "7";
                break;
            case preg_match('/^'.$hit['patlast'].', ([A-Z][a-z]+) III (('.$hit['patfirst'].')( )?)?( (S\.)?)?$/', $search):
                // code to execute for names that match pattern 8
                  $fullname =  $hit['patlast'].', '.$hit['patfirst'].' '.$hit['patsuffix'];          
                  $pattern = "8";
                break;
            case preg_match('/^'.$hit['patlast'].', ([A-Z][a-z]+) (('.$hit['patfirst'].')( )?)?( (S\.)?)? Jr$/', $search):
                // code to execute for names that match pattern 9
                  $fullname =  $hit['patlast'].', '.$hit['patfirst'].' '.$hit['patmiddle'].' '.$hit['patsuffix'];          
                  $pattern = "9";
                break;
            case preg_match('/^'.$hit['patlast'].', ([A-Z][a-z]+)( (S\.)?)? Sr$/', $search):
                // code to execute for names that match pattern 10
                  $fullname = $hit['patlast'].', '.$hit['patfirst'].' '.substr($hit['patmiddle'],1).'., '.$hit['patsuffix'];          
                  $pattern = "10";
                break;
              default:
                  $fullname =  str_replace('-', '', $hit['patlast']) .  $hit['patfirst'] . $hit['patmiddle'] . (isset($hit['patsuffix']) && $hit['patsuffix'] != "" ? $hit['patsuffix']:"");
                  $pattern = "0";
                break;
              }

          // switch (true) {
          //   case preg_match('/^'.$hit['patfirst'].' '.$hit['patlast'].' '.$hit['patsuffix'].'$/', $search):
          //       $fullname = $hit['patfirst'].' '.$hit['patlast'].' '.$hit['patsuffix'];
          //       $pattern = "1";
          //       break;
          //   case preg_match('/^'.$hit['patfirst'].' '.$hit['patlast'].', '.$hit['patsuffix'].'$/', $search):
          //       $fullname =  $hit['patfirst'].' '.$hit['patlast'].', '.$hit['patsuffix'];
          //       $pattern = "2";
          //       break;
          //   case preg_match('/^'.$hit['patfirst'].' '.$hit['patmiddle'].' '.$hit['patlast'].'$/', $search):
          //       $fullname =  $hit['patfirst'].' '.$hit['patmiddle'].' '.$hit['patlast'];
          //       $pattern = "3";
          //       break;
          //   case preg_match('/^'.$hit['patfirst'].' '.$hit['patmiddle'].' '.$hit['patlast'].', '.$hit['patsuffix'].'$/', $search):
          //       $fullname =  $hit['patfirst'].' '.$hit['patmiddle'].' '.$hit['patlast'].', '.$hit['patsuffix'];
          //       $pattern = "4";
          //       break;
          //   case preg_match('/^'.$hit['patfirst'].' '.substr($hit['patmiddle'],1).'. '.$hit['patlast'].'$/', $search):
          //       $fullname =  $hit['patfirst'].' '.substr($hit['patmiddle'],1).'. '.$hit['patlast'];
          //       $pattern = "5";
          //       break;
          //   case preg_match('/^'.$hit['patfirst'].' '.substr($hit['patmiddle'],1).'. '.$hit['patlast'].', '.$hit['patsuffix'].'$/', $search):
          //       $fullname =  $hit['patfirst'].' '.substr($hit['patmiddle'],1).'. '.$hit['patlast'].', '.$hit['patsuffix'];
          //       $pattern = "6";
          //       break;
          //   case preg_match('/^'.$hit['patfirst'].' '.substr($hit['patmiddle'],1).'. '.$hit['patlast'].' '.$hit['patsuffix'].'$/', $search):
          //       $fullname =  $hit['patfirst'].' '.substr($hit['patmiddle'],1).'. '.$hit['patlast'].' '.$hit['patsuffix'];
          //       $pattern = "7";
          //       break;
          //   case preg_match('/^'.$hit['patlast'].', '.$hit['patfirst'].' '.$hit['patsuffix'].'$/', $search):
          //       $fullname =  $hit['patlast'].', '.$hit['patfirst'].' '.$hit['patsuffix'];
          //       $pattern = "8";
          //       break;
          //   case preg_match('/^'.$hit['patlast'].', '.$hit['patfirst'].' '.$hit['patmiddle'].' '.$hit['patsuffix'].'$/', $search):
          //       $fullname =  $hit['patlast'].', '.$hit['patfirst'].' '.$hit['patmiddle'].' '.$hit['patsuffix'];
          //       $pattern = "9";
          //       break;
          //   case preg_match('/^'.$hit['patlast'].', '.$hit['patfirst'].' '.substr($hit['patmiddle'],1).'., '.$hit['patsuffix'].'$/', $search):
          //       $fullname = $hit['patlast'].', '.$hit['patfirst'].' '.substr($hit['patmiddle'],1).'., '.$hit['patsuffix'];
          //       $pattern = "10";
          //       break;
          //   default:
          //       $fullname =  str_replace('-', '', $hit['patlast']) .  $hit['patfirst'] . $hit['patmiddle'] . (isset($hit['patsuffix']) && $hit['patsuffix'] != "" ? $hit['patsuffix']:"");
          //       $pattern = "0";
          //       break;
          // }



      
        $fullname =  str_replace('-', '', $hit['patlast']) .  $hit['patfirst'] . $hit['patmiddle'] . (isset($hit['patsuffix']) && $hit['patsuffix'] != "" ? $hit['patsuffix']:"");
        // $fullname =  str_replace('-', '', $hit['patlast']) . ", " . $hit['patfirst'] . " " . $hit['patmiddle'] . (isset($hit['patsuffix']) && $hit['patsuffix'] != ""? ", " . $hit['patsuffix']:"");
      }else if($hit['fullname_last'] != ""){
        $fullname =  str_replace('-', '', $hit['fullname_last']);
      }else if($hit['fullname_first'] != ""){
        $fullname =  str_replace('-', '', $hit['fullname_first']);
      } 
    }


    if (preg_match("/\d{2}-\d{2}-\d{2}/", $search)) {
      $matchPercentage = $fuzz->ratio(strtoupper($search), $hit['hpercode']);
      $similarity = $fuzz->tokenSetRatio(strtoupper($search), $hit['hpercode']);
    }else{
      $matchPercentage = $fuzz->ratio(  metaphone(strtoupper($search)), metaphone(strtoupper($fullname))  );
      $similarity = $fuzz->tokenSetRatio( strtoupper($search), strtoupper(str_replace('-', '', $hit['fullname'])));
    }
    
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
    // echo  metaphone($hit['patlast']) . ", ". metaphone($hit['patfirst'])." = ". metaphone(strtoupper($search)) . ': ' . json_encode($matchPercentage)."<br>";
    echo  metaphone($fullname)." = ". metaphone(strtoupper($search)) . ": [$pattern] :" . json_encode($matchPercentage)."<br>";
  }
  $hits = array_merge($highHit,$midHit,$lowHit);
  arsort($rank);

  // echo json_encode($rank);
  // die();

  $filteredResult = [];
  $lastFullname = [];
 ?>
<?php foreach ($rank as $profile): ?>
  <?php 

    if ( $profile['data']['patfirst'] != "" && str_replace('-', '', $profile['data']['patlast'])  ) {
      $fullname =  str_replace('-', '', $profile['data']['patlast']) . ", " . $profile['data']['patfirst'] . " " . $profile['data']['patmiddle'] . (isset($profile['data']['patsuffix']) && $profile['data']['patsuffix'] != ""? ", " . $profile['data']['patsuffix']:"");
      $ofullname =  "<span style=\"font-weight:bold; text-decoration:underline; color:#ee5500;\">".$profile['data']['patlast'] . "</span>, " . $profile['data']['patfirst'] . " " . $profile['data']['patmiddle'] . (isset($profile['data']['patsuffix']) && $profile['data']['patsuffix'] != ""? " " . $profile['data']['patsuffix']:"");
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
            $speed = endtest()-$speed;
            array_push($filteredResult,$profile['data']);

            $firstPersonnel = $registry->getPersonnelID( trim($profile['data']['entryby']));
            $fpFullname = $firstPersonnel['data'][0]['empprefix'] . " " . $firstPersonnel['data'][0]['firstname'] . ' ' . $firstPersonnel['data'][0]['lastname'];

            // die(json_encode(fpFullname));
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

            $admByID = $registry->getAdmissionByID(trim($hpercode));
            $lastAdmission = date('M d, Y h:i a', strtotime($admByID['data'][0]['admdate']));

            $lastAdmit = isset($admitResult) && count( $admitResult) > 0 ? date('M d, Y h:i a', strtotime($admitResult['data'][0]['admdate'])) : "NO ADMISSION RECORD";
            $lastOPD = isset($opdResult) && count( $opdResult) > 0 ? date('M d, Y h:i a', strtotime($opdResult['data'][0]['opddate'])) : "NO OPD RECORD";
            
            $now = new DateTime();
            $bday = $now->diff($bate);
            // $duplicate = $registry->getDuplicateByName($fullname);
            // die(json_encode($lastAdmission));
            // die("ERROR");
            // die($lastAdmit);
            // die(json_encode($opdResult));

         ?>

            <div class="card border-info mb-3" style="">
              <div class="card-header" style="display: inline;">
                <span class="bg-yellow-1" style="padding:5px; border-radius: 5px; color: #222;">Hospital ID: <b style="color: black; font-weight: 900;"><?= $profile['data']['hpercode']; ?></b></span>
                <span style=""> 
                  <?php if (count( $admitResult['data']) > 0): ?>                    
                    <span class="bg-orange-1 border-danger" style="padding:5px; font-size:9pt; margin-right:5px; border-radius: 5px; color: #eeeeee;">
                    Last Admission: <b><u><?= $lastAdmit; ?></u></b>
                    </span>
                  <?php endif ?>
                  <?php if (count( $opdResult['data']) > 0): ?>                  
                    <span class="bg-blue-1" style="padding:5px; font-size:9pt; margin-right:5px; border-radius: 5px; color: #FFFFFF;">
                    Last OPD Consultation: <b><u><?= $lastOPD; ?></u></b>
                    </span>
                  <?php endif ?>
                  <span class="bg-green-1" style="padding:5px; font-size:9pt;  margin-right:5px; border-radius: 5px; color: #FFFFFF;">
                  Entry By: <b><u><?= $fpFullname; ?></u></b>
                  </span>
                  <span class="bg-green-1" style="padding:5px; font-size:9pt; border-radius: 5px; color: #FFFFFF;">
                  Match: <b><u><?= $probability; ?>%</u></b>
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
    if (count($filteredResult) > 0) {
      $redis->set( 'q_' . strtolower(preg_replace('/[^a-zA-Z0-9\']/', '', $keyresult)), json_encode($filteredResult));
    }
  }
 ?>
<script>

  $("#hit").text("<?=$hitCount==0?'':$hitCount; ?>");
  $("#notes").text(" <?=$notes; ?>");

</script>