 <?php 
global $registry;
include 'dashboard.controller.php';

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
R::selectDatabase('HOSPITAL');
header("Content-type: application/json; charset=utf-8");

function save()
{
	global $registry;
	$categoryid="";
	$description="";
	
	if (isset($_POST)) {
		$categoryid = isset($_POST["categoryid"]) && $_POST["categoryid"] != "" ? $_POST["categoryid"] : "" ;
		$description = isset($_POST["description"]) && $_POST["description"] != "" ? $_POST["description"]: "" ;
		$fileattachment = isset($_FILE["fileattachment"]) && $_FILE["fileattachment"] != "" ? $_FILE["fileattachment"]: "" ;
		$data = array(
			'categoryid' => $categoryid,
			'description' => $description 
		);
		if ($categoryid != "" && $description !="") {
			$result = $registry->saveJobOrder($data);
			// $result = $registry->UploadFileAttachment();
			// $result= "SUCCESS";
		}else{
			$result = "FAILED " . json_encode($data);
		}
		return $result;
	}
}


$search = isset($_GET['search']) ? trim($_GET['search']) : trim(isset($_POST['search']) ?  trim($_POST['search']) : "" ) ;
$patname = isset($_GET['name']) ? trim($_GET['name']) : trim(isset($_POST['name']) ?  trim($_POST['name']) : "" ) ;
$objid = isset($_GET['objid']) ? trim($_GET['objid']) : "" ;
$method = isset($_GET['method']) ? trim($_GET['method']) : "" ;
$action = isset($_GET['action']) ? trim($_GET['action']) : "" ;
$dsresult = [];

$search = str_replace("/", "", $search);
$search = str_replace("\\", "", $search);

$opt = preg_match('/(\d{1,2})-(\d{1,2})-(\d{1,2})/', $patname)? "id" : "other";

if ($opt == "id") {
    $opt = preg_match('/(\d{1,2})-(\d{1,2})-(\d{1,2})/', $patname)? "id" : "other";
}elseif ($opt == "other") {
    if(count(explode(' ', $patname)) > 1){
        $opt = preg_match('/^([\w ]+)+, +([\w ]+)/', $patname)? "last" : "first";
    }else{
        $opt = "single";
    }
}





if ($objid != "") {
	if ($action == "verified") {
		$dsresult = array("result"=>$registry->addtoValidatedlist($objid));
	}
	header('Location: ?page=registry');
}else{


	switch ($method) {
		case 'get':
				switch ($action) {
					case 'getadmission':
							$dsresult = $registry->getAdmissionByID("$search");
						break;
					default:
							$dsresult = $registry->GetTotalCluster()[0]['total'];
						break;
				}
			break;
		
		default:
				if ($patname != "" && $patname != null) {
				    switch ($opt) {
				        case 'id':
				           $dsresult = array("result"=>$registry->getEntityByID($patname), "option"=>$opt);
				            break;        
				        case 'first':
				           $dsresult = array("result"=>$registry->getEntityByFirstName($patname), "option"=>$opt);
				            break;        
				        case 'last':
				           $dsresult = array("result"=>$registry->getEntityByLastName($patname), "option"=>$opt);
				            break;        
				        default:
					        
				            break;
				    }
				    
				}else if($search != "" && $search != null){
							if (isset($_GET['device']) && $_GET['device'] == 'desktop') {
				        		$sensitivity = isset($_GET['sensitivity']) ? $_GET['sensitivity'] : 80 ; 
				           	    $data = $registry->getEntityByUnknownSingle(strtoupper($search));
				           	    $resultData = [];
				           	    $rank = [];
							    $highHit = [];
							    $midHit = [];
							    $lowHit = [];
							    $lessHit = [];
							    foreach ($data as $hit) {
								    if ( $hit['patfirst'] != "" && str_replace('-', '', $hit['patlast'])  ) {
								      $fullname =  str_replace('-', '', $hit['patlast']) . ", " . $hit['patfirst'] . " " . $hit['patmiddle'] . (isset($hit['patsuffix']) && $hit['patsuffix'] != ""? ", " . $hit['patsuffix']:"");
								    }else if($hit['fullname_last'] != ""){
								      $fullname =  str_replace('-', '', $hit['fullname_last']);
								    }else if($hit['fullname_first'] != ""){
								      $fullname =  str_replace('-', '', $hit['fullname_first']);
								    }else if($hit['payroll'] != ""){
								      $fullname =  str_replace('-', '', $hit['payroll']);
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

							foreach ($rank as $profile){

									if ( $profile['data']['patfirst'] != "" && str_replace('-', '', $profile['data']['patlast'])  ) {
								      $fullname =  str_replace('-', '', $profile['data']['patlast']) . ", " . $profile['data']['patfirst'] . " " . $profile['data']['patmiddle'] . (isset($profile['data']['patsuffix']) && $profile['data']['patsuffix'] != ""? ", " . $profile['data']['patsuffix']:"");
								    }else if($profile['data']['fullname_last'] != ""){
								      $fullname =  str_replace('-', '', $profile['data']['fullname_last']);
								    }else if($profile['data']['fullname_first'] != ""){
								      $fullname =  str_replace('-', '', $profile['data']['fullname_first']);
								    }else if($profile['data']['pauroll'] != ""){
								      $fullname =  str_replace('-', '', $profile['data']['payroll']);
								    }

								    $probability = $fuzz->tokenSetRatio(strtoupper($search), strtoupper($fullname));
								    if ($profile['rank'] >= $sensitivity){
								    	array_push($resultData,$profile['data']);
								    }
							}
		           	  		$dsresult = array("result"=>$resultData, "option"=>$rank);
		           	  		// $dsresult = array("result"=>$rank);

			        }else{
			           $dsresult = array("result"=>$registry->getEntityByUnknownSingle($search), "option"=>$opt);
			        }
				}
				else{
				    $dsresult = array("result"=>$_POST);
				}

			break;
	}


	echo json_encode($dsresult);
}

