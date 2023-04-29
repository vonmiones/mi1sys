 <?php 
global $registry;
include 'dashboard.controller.php';
$registry = new RegistryModel();
R::selectDatabase('SOCIALENTITY');
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


$patname = isset($_GET['name']) ? trim($_GET['name']) : "" ;
$objid = isset($_GET['objid']) ? trim($_GET['objid']) : "" ;
$method = isset($_GET['method']) ? trim($_GET['method']) : "" ;
$action = isset($_GET['action']) ? trim($_GET['action']) : "" ;
$dsresult = [];

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


header('Content-Type: application/json;');


if ($objid != "") {
	if ($action == "verified") {
		$dsresult = array("result"=>$registry->addtoValidatedlist($objid));
	}
	header('Location: ?page=registry');
}else{


	switch ($method) {
		case 'get':
				switch ($action) {
					case 'tudelaverified':
							$dsresult = $registry->GetTudelaVerified()[0]['total'];
						break;
					case 'clarinverified':
							$dsresult = $registry->GetClarinVerified()[0]['total'];
						break;
					case 'verified':
							$dsresult = $registry->GetValidatedData();
						break;
					case 'total':
							$dsresult = $registry->GetValidatedDataCount();
						break;
					case 'clusterlist':
							$dsresult = $registry->GetClusterList();
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
				           $dsresult = array("result"=>$registry->getEntityByUnknownSingle($patname), "option"=>$opt);
				            break;
				    }
				    
				}else{
				    $dsresult = array("result"=>null);
				}

			break;
	}


	echo json_encode($dsresult);
}

