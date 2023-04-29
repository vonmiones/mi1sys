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
R::selectDatabase('HOSPITAL');

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

echo "Entries: <b><u>".count($result)."</u></b>, <b><u><span id=\"hit\"></span></b></u><span id=\"notes\"></span>";

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
    }else if($hit['payroll'] != ""){
      $fullname =  str_replace('-', '', $hit['payroll']);
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
 <div id="result">
   
 </div>
<script>
  function roll() {
    var r = Math.random();
    var x = Math.round(r*<?=count($result);?>,0);
      // setInterval(function(){
      //   $("#result").append(x);
      //   console.log(x);
      // },2000);
  }
  roll();
</script>