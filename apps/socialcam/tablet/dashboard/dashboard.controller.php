<?php

class RegistryModel
{
	
	function __construct()
	{
		self::init();
	}
	function GetCategories()
	{
		return [];
	}
	function GetMyJobRequest()
	{
		return [];
	}
	function init()
	{
		R::addDatabase('SOCIALENTITY','mysql:host='.SYSTEMDBHOST.';dbname='.SYSTEMDBNAME.'_socialworks',SYSTEMDBUSER, SYSTEMDBPASS );
		R::close();
	}
	function GetTotalCluster()
	{
		return R::getAll( 'SELECT count(*) as total FROM entity' );
	}

	function GetTudelaVerified()
	{
		return R::getAll( 'SELECT count(*) as total FROM entity WHERE citymun = "TUDELA" AND txnstatus = "VALIDATED" ' );
	}

	// function GetValidatedData()
	// {
	// 	return R::getAll( 'SELECT payroll,
	// 						CASE WHEN last_name  IS NULL 
	// 								THEN 
	// 									CASE WHEN fullname_last IS NULL 
	// 											THEN fullname_first
	// 											ELSE fullname_last 
	// 									END
	// 							ELSE CONCAT(last_name,", ",first_name," ",middle_name," ",suffix)  
	// 							END AS fullname,
	// 						birthdate,barangay,citymun,province,amount,teller 
	// 						FROM entity 
	// 						WHERE txnstatus = "VALIDATED" 
	// 						ORDER BY dtvalidated DESC' );
	// }

	function GetValidatedData()
	{
		return R::getAll( 'SELECT payroll,
								IF(
									(last_name IS NULL OR last_name = "") AND (fullname_last != "" OR fullname_last IS NOT NULL), fullname_last, 
										CONCAT(last_name, ", ",first_name," ",IF(
											middle_name IS NULL OR middle_name = "",""
											,middle_name
											))) as fullname,
							TIMESTAMPDIFF(YEAR,birthdate,CURDATE()) AS age,barangay,citymun,province,txnstatus,teller 
							FROM entity 
							WHERE txnstatus = "VALIDATED" 
							ORDER BY dtvalidated DESC' );
	}

	function GetValidatedDataCount()
	{
		return R::getAll( 'SELECT COUNT(*) as total FROM entity WHERE txnstatus = "VALIDATED"' );
	}

	function GetClusterList()
	{
		return R::getAll( 'SELECT * FROM entity' );
	}

	function GetClarinVerified()
	{
		return R::getAll( 'SELECT count(*) as total FROM entity  WHERE citymun = "CLARIN" AND txnstatus = "VALIDATED" ' );
	}

	function GetValidatedListEntity($id)
	{
		return R::getAll( 'SELECT * FROM validatedlist  WHERE objid = '.$id );
	}

	function getEntityByID($id)
	{
	    $currentYear = date('Y');
	    $result = R::getAll("SELECT * FROM entity a WHERE a.id = '$id';");
	    return $result;
	}

	function getEntityByFirstName($patname)
	{
	    $result = R::getAll("
	        SELECT * FROM entity a WHERE 
	        	SOUNDEX(CONCAT(first_name,' ',middle_name,' ', last_name, ' ' , suffix)) = SOUNDEX('%$patname%')
	        OR	SOUNDEX(CONCAT(first_name,' ',middle_name,' ', last_name, ',' , suffix)) = SOUNDEX('%$patname%')
	        OR 	SOUNDEX(CONCAT(first_name,' ',middle_name,' ', last_name)) = SOUNDEX('%$patname%')
	        ORDER BY a.last_name ASC
	        LIMIT 1000;
	    ");
	    return $result;
	}

	function getEntityByLastName($patname)
	{
	    $result = R::getAll("
	        SELECT * FROM entity a WHERE 
				SOUNDEX(CONCAT(last_name,' ',first_name,' ', middle_name)) = SOUNDEX('%$patname%')
			OR	SOUNDEX(CONCAT(last_name,', ',first_name,' ', middle_name)) = SOUNDEX('%$patname%')
	        ORDER BY a.last_name ASC
	        LIMIT 1000;
	    ");
	    return $result;
	}

	// function getEntityByUnknownSingle($patname)
	// {
	// 	$split = explode(' ', $patname);
	// 	$qArray = [];
	// 	$q = '';
	// 	foreach ($split as $key) {
	// 		array_push($qArray, " OR (SOUNDEX(CONCAT(last_name)) = SOUNDEX('%$key%')  AND ( txncode IS NULL OR txncode = 0 ) )");
	// 		array_push($qArray, " OR (SOUNDEX(CONCAT(first_name)) = SOUNDEX('%$key%')  AND ( txncode IS NULL OR txncode = 0 ) )");
	// 		array_push($qArray, " OR (SOUNDEX(CONCAT(middle_name)) = SOUNDEX('%$key%')  AND ( txncode IS NULL OR txncode = 0 ) )");
	// 	}
	// 	$q = implode(' ',$qArray);
	//     $result = R::getAll("
	//          SELECT * FROM entity a WHERE 
	//         	(SOUNDEX(CONCAT(first_name,' ',middle_name,' ', last_name)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  (SOUNDEX(CONCAT(last_name,' ',first_name,' ', middle_name)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  (SOUNDEX(CONCAT(last_name,', ',first_name,' ', middle_name)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  (SOUNDEX(CONCAT(first_name,' ', last_name)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  (SOUNDEX(CONCAT(last_name,' ', first_name)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  (SOUNDEX(CONCAT(last_name)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  (SOUNDEX(CONCAT(first_name)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  (SOUNDEX(CONCAT(middle_name)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		$q
	//         ORDER BY a.last_name ASC
	//         LIMIT 1000;
	//     ");
	//     return $result;
	// }

	// function getEntityByUnknownSingle($patname)
	// {
	// 	$split = explode(' ', $patname);
	// 	$rsplit = array_reverse($split);
	// 	$qArray = [];
	// 	$q = '';
	// 	foreach ($split as $key) {
	// 		array_push($qArray, " OR ( SOUNDEX(last_name) = SOUNDEX('%$key%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(first_name) = SOUNDEX('%$key%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(middle_name) = SOUNDEX('%$key%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 	}
	// 	foreach ($rsplit as $key) {
	// 		array_push($qArray, " OR ( SOUNDEX(last_name) = SOUNDEX('%$key%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(first_name) = SOUNDEX('%$key%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(middle_name) = SOUNDEX('%$key%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 	}

	// 	if (count($split) > 1) {
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(first_name,' ' , last_name)) = SOUNDEX('%".$split[1].' '.$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(first_name,' ' , middle_name)) = SOUNDEX('%".$split[1].' '.$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(last_name,' ' , first_name)) = SOUNDEX('%".$split[0].' '.$split[1]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(last_name,' ' , middle_name)) = SOUNDEX('%".$split[1].' '.$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(middle_name,' ' , first_name)) = SOUNDEX('%".$split[0].' '.$split[1]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(middle_name,' ' , last_name)) = SOUNDEX('%".$split[1].' '.$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(first_name) = SOUNDEX('%".$split[0].' '.$split[1]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(first_name) = SOUNDEX('%".$split[1].' '.$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(last_name) = SOUNDEX('%".$split[0].' '.$split[1]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(last_name) = SOUNDEX('%".$split[1].' '.$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(middle_name) = SOUNDEX('%".$split[0].' '.$split[1]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(middle_name) = SOUNDEX('%".$split[1].' '.$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 	}else{
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(first_name,' ' , last_name)) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(first_name,' ' , middle_name)) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(last_name,' ' , first_name)) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(last_name,' ' , middle_name)) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(middle_name,' ' , first_name)) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(middle_name,' ' , last_name)) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(first_name) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(first_name) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(last_name) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(last_name) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(middle_name) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 	}

		
	// 	$q = implode(' ',$qArray);

	//     $result = R::getAll("
	//          SELECT * FROM entity a WHERE 
	//         	( SOUNDEX(CONCAT(first_name,' ',middle_name,' ', last_name)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(CONCAT(last_name,' ',first_name,' ', middle_name)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(CONCAT(last_name,', ',first_name,' ', middle_name)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(CONCAT(first_name,' ', last_name)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(CONCAT(last_name,' ', first_name)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(last_name) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(first_name) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(middle_name) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(fullname_last) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(fullname_first) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		$q;
	//     ");
	//     return $result;
	// }


	function getEntityByUnknownSingle($patname)
	{
		$split = explode(' ', $patname);
		$rsplit = array_reverse($split);
		$qArray = [];
		$q = '';
		foreach ($split as $key) {
			array_push($qArray, " OR SOUNDEX(last_name) = SOUNDEX('%$key%') ");
			array_push($qArray, " OR SOUNDEX(first_name) = SOUNDEX('%$key%') ");
			array_push($qArray, " OR SOUNDEX(middle_name) = SOUNDEX('%$key%') ");
		}
		foreach ($rsplit as $key) {
			array_push($qArray, " OR SOUNDEX(last_name) = SOUNDEX('%$key%') ");
			array_push($qArray, " OR SOUNDEX(first_name) = SOUNDEX('%$key%') ");
			array_push($qArray, " OR SOUNDEX(middle_name) = SOUNDEX('%$key%') ");
		}

		if (count($split) > 1) {
			array_push($qArray, " OR SOUNDEX(CONCAT(first_name,' ' , last_name)) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(first_name,' ' , middle_name)) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(last_name,' ' , first_name)) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(last_name,' ' , middle_name)) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(middle_name,' ' , first_name)) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(middle_name,' ' , last_name)) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(first_name) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
			array_push($qArray, " OR SOUNDEX(first_name) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(last_name) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
			array_push($qArray, " OR SOUNDEX(last_name) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(middle_name) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
			array_push($qArray, " OR SOUNDEX(middle_name) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
		}else{
			array_push($qArray, " OR SOUNDEX(CONCAT(first_name,' ' , last_name)) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(first_name,' ' , middle_name)) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(last_name,' ' , first_name)) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(last_name,' ' , middle_name)) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(middle_name,' ' , first_name)) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(middle_name,' ' , last_name)) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(first_name) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(last_name) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(middle_name) = SOUNDEX('%".$split[0]."%') ");
		}

		$q = implode(' ',$qArray);

	    $result = R::getAll("
	         SELECT * FROM entity a WHERE 
	        	SOUNDEX(CONCAT(first_name,' ',middle_name,' ', last_name)) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(CONCAT(last_name,' ',first_name,' ', middle_name)) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(CONCAT(last_name,', ',first_name,' ', middle_name)) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(CONCAT(first_name,' ', last_name)) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(CONCAT(last_name,' ', first_name)) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(last_name) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(first_name) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(middle_name) = SOUNDEX('%$patname%')
			OR 	fullname_last LIKE '%$patname%'
			OR 	fullname_first LIKE '%$patname%'
			$q;
	    ");
	    return $result;
	}



	function saveJobOrder($data)
	{
		$j = self::SaveNewJobOrder($data);
		$ji = self::SaveNewJobOrderItems($j,$data);
		return json_encode($ji);
	}

	function UploadFileAttachment()
	{
		if ( 0 < $_FILES['file']['error'] ) {
        	echo 'Error: ' . $_FILES['file']['error'] . '<br>';
	    }
	    else {
	        move_uploaded_file($_FILES['file']['tmp_name'], 'documents/apps/socialcam/attachments/' . $_FILES['file']['name']);
	    }
	    return $_FILES['file']['name'];
	}

	function SaveNewJobOrder($data)
	{
		$q = R::dispense('joborder');
		// $q->requestorid = $data["requestorid"];
		// $q->order_code = $data["order_code"];
		$q->categoryid = $data["categoryid"];
		// $q->metadata = $data["metadata"];
		// $q->isparent = $data["isparent"];
		// $q->parentid = $data["parentid"];
		$q->dt_stamp = date("Y-m-d H:i:s");
	    // $q->hash = sha1($data["order_code"] . ":" . $data["dt_stamp"]);
	    $id = R::store( $q );
	    return R::load( 'joborder', $id);
	}

	function SaveNewJobOrderItems($idx,$data)
	{
		$file = self::UploadFileAttachment();
		$q = R::dispense('joborderitems');
		// $q->personnel = $data["personnel"]; 
		$q->joborder = $idx; 
		$q->attachments = $file; 
		$q->description = $data["description"]; 
		$q->dt_stamp = date("Y-m-d H:i:s");
		// $q->action_status = $data["action_status"]; 
		// $q->order_status = $data["order_status"]; 
		// $q->level = $data["level"]; 
		// $q->escallation = $data["escallation"]; 
	    $id = R::store( $q );
	    return R::load( 'joborderitems', $id);
	}
 




	function addtoValidatedlist($data)
	{
	    R::close();
	    R::selectDatabase('SOCIALENTITY');
	    $objid = trim($data);
		$id = R::findOne('entity','id=?',[ $objid ])['id'];
	    $table = R::load( 'entity',$id);
	    $table->dtvalidated = date('Y-m-d H:i:s');
	    $table->txnstatus = "VALIDATED";
	    $table->txncode = 1;
	    $table->txnuser = $_COOKIE['_uid'];

	    $id = R::store( $table );
	    return R::load( 'entity', $id);
	}

	
	function delete($objid)
	{
	    $id = R::findOne('caaidregistry','objid=?',[$objid])['id'];
		$t = R::load('caaidregistry', $id);
		R::trash( $t );
	    return R::load( 'caaidregistry', $id);
	}	

}

