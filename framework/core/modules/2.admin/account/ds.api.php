<?php
$token = new NameTokenizer();
$method = isset($_POST["method"]) ? $_POST['method']: "";
$action = isset($_POST["action"]) ? $_POST['action']: "";
$appids = isset($_POST["appids"]) ? $_POST['appids']: "";
$appnames = isset($_POST["appnames"]) ? $_POST['appnames']: "";
$role = isset($_POST["role"]) ? $_POST['role']: "";
$object = isset($_POST["object"]) ? $_POST['object']: "";
$id = isset($_POST["id"]) ? $_POST['id']: "";
$entity = isset($_POST["entity"]) ? $_POST['entity']: "";
$user = isset($_POST["user"]) ? $_POST['user']: "";
$pass = isset($_POST["pass"]) ? $_POST['pass']: "";
$email = isset($_POST["email"]) ? $_POST['email']: "";
$role = isset($_POST["role"]) ? $_POST['role']: "";
$office = isset($_POST["office"]) ? $_POST['office'] : "";
$lastname = isset($_POST["lastname"]) ? $_POST['lastname'] : "";
$firstname = isset($_POST["firstname"]) ? $_POST['firstname'] : "";
$middlename = isset($_POST["middlename"]) ? $_POST['middlename'] : "";
$suffix = isset($_POST["suffix"]) ? $_POST['suffix'] : "";
$civilstatus = isset($_POST["civilstatus"]) ? $_POST['civilstatus'] : "";
$nationality = isset($_POST["nationality"]) ? $_POST['nationality'] : "";
$ethnicgroup = isset($_POST["ethnicgroup"]) ? $_POST['ethnicgroup'] : "";
$withchildren = isset($_POST["withchildren"]) ? $_POST['withchildren'] : "";
$ispwd = isset($_POST["ispwd"]) ? $_POST['ispwd'] : "";
$idmulticitizenship = isset($_POST["idmulticitizenship"]) ? $_POST['idmulticitizenship'] : "";
$isipmember = isset($_POST["isipmember"]) ? $_POST['isipmember'] : "";
$birthdate = isset($_POST["birthdate"]) ? $_POST['birthdate'] : "";
// $address = isset($_POST["address"]) ? $_POST['address'] : "";
$addresslotblock = isset($_POST["addresslotblock"]) ? $_POST['addresslotblock'] : "";
$addresssubdivision = isset($_POST["addresssubdivision"]) ? $_POST['addresssubdivision'] : "";
$addresspurok = isset($_POST["addresspurok"]) ? $_POST['addresspurok'] : "";
$addressbarangay = isset($_POST["addressbarangay"]) ? $_POST['addressbarangay'] : "";
$addresscitymun = isset($_POST["addresscitymun"]) ? $_POST['addresscitymun'] : "";
$addressprovince = isset($_POST["addressprovince"]) ? $_POST['addressprovince'] : "";
$addressdistrict = isset($_POST["addressdistrict"]) ? $_POST['addressdistrict'] : "";
$addressregion = isset($_POST["addressregion"]) ? $_POST['addressregion'] : "";
$addresszipcode = isset($_POST["addresszipcode"]) ? $_POST['addresszipcode'] : "";
$bloodtype = isset($_POST["bloodtype"]) ? $_POST['bloodtype'] : "";
$height = isset($_POST["height"]) ? $_POST['height'] : "";
$weight = isset($_POST["weight"]) ? $_POST['weight'] : "";
$otherphysical = isset($_POST["otherphysical"]) ? $_POST['otherphysical'] : "";

switch ($method ) {
	case 'saveAccount':
		if ($method != "") {
			$data = array(
				"object"=>$token->FormName($object,'decrypt'),
				"entity"=>$entity,
				"user"=>$user,
				"pass"=>$pass,
				"role"=>$role,
				"email"=>$email	
			);
			switch ($action) {
				case 'update':
					echo "$action " . json_encode(updateAccount($data));
					break;
				
				default:
						if (count(checkExistingAccount($data)) < 1) {
							echo json_encode(array("result"=>"Account Saved!","data"=>saveAccount($data) ));
						}else if(count(checkExistingAccount($data)) > 1){
							echo json_encode( array("result"=>"multiple entry, these account will automatically be halted in the database") );
							foreach (checkExistingAccount($data) as $d) {
								echo disableAccount($d);
							}
						}
						else{
							echo json_encode(array("result"=>"account already exists!"));
						}
					break;
			}
		}
		break;
	case 'deleteAccount':
		if ($method != "") {
			if (isset($object) && $object != "") {
				$data = array(
					"object"=>$token->FormName($object,'decrypt')
				);
				if(count(checkExistingAccount($data)) > 1){
					echo json_encode( array("result"=>"multiple entry, these account will automatically be halted in the database") );
					foreach (checkExistingAccount($data) as $d) {
						echo disableAccount($d);
					}
				}
				else{
					echo json_encode(deleteAccount($data));
				}
			}else{
				echo json_encode(array("result"=>"account not create"));
			}

			// echo json_encode(deleteAccount($data));
		}
		break;
	case 'disableAccount':
		if ($method != "") {
			$data = array(
				"object"=>$token->FormName($object,'decrypt')
			);
			echo json_encode(disableAccount($data));
		}
		break;
	case 'saveRole':
		if ($method != "") {
			
			$data = array(
				"appids"=>$appids,
				"appnames"=>$appnames,
				"role"=>$role,			
				"object"=>$object			
			);
			switch ($action) {
				case 'update':
					echo "$action " .  json_encode(updateRole($data));
					break;
				
				default:
					echo json_encode(saveRole($data));
					break;
			}
		}
		break;
	case 'newentity':
		if ($method != "") {
			
			$data = array(
				"office"=>"",
				"lastname"=>$lastname,
				"firstname"=>$firstname,
				"middlename"=>$middlename,
				"suffix"=>$suffix,
				"civilstatus"=>$civilstatus,
				"nationality"=>$nationality,
				"ethnicgroup"=>$ethnicgroup,
				"withchildren"=>$withchildren,
				"ispwd"=>$ispwd,
				"idmulticitizenship"=>$idmulticitizenship,
				"isipmember"=>$isipmember,
				"birthdate"=>$birthdate,
				// "address"=>$address,
				"addresslotblock"=>$addresslotblock,
				"addresssubdivision"=>$addresssubdivision,
				"addresspurok"=>$addresspurok,
				"addressbarangay"=>$addressbarangay,
				"addresscitymun"=>$addresscitymun,
				"addressprovince"=>$addressprovince,
				"addressdistrict"=>$addressdistrict,
				"addressregion"=>$addressregion,
				"addresszipcode"=>$addresszipcode,
				"bloodtype"=>$bloodtype,
				"height"=>$height,
				"weight"=>$weight,
				"otherphysical"=>$otherphysical,

			);

			echo json_encode(newentity($data));
		}
		break;
	
	default:
		// code...
		break;
}