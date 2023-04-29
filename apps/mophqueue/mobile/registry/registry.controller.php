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

	function GetValidatedData()
	{
		return R::getAll( 'SELECT * FROM entity WHERE txnstatus = "VALIDATED" LIMIT 50' );
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

	// function getEntityByFirstName($patname)
	// {
	//     $result = R::getAll("
	//         SELECT * FROM entity a WHERE SOUNDEX(CONCAT(last_name,', ',first_name,' ',middle_name)) LIKE CONCAT('%',SOUNDEX('$patname'),'%')
	//         OR SOUNDEX(CONCAT(first_name,' ',middle_name, ' ', last_name)) LIKE CONCAT('%',SOUNDEX('$patname'),'%')
	//         OR SOUNDEX(CONCAT(first_name,', ',last_name)) LIKE CONCAT('%',SOUNDEX('$patname'),'%')
	//         OR SOUNDEX(CONCAT(first_name)) LIKE CONCAT('%',SOUNDEX('$patname'),'%')
	//         ORDER BY a.last_name ASC
	//         LIMIT 1000;
	//     ");
	//     return $result;
	// }

	// function getEntityByLastName($patname)
	// {
	//     $result = R::getAll("
	//         SELECT * FROM entity a WHERE SOUNDEX(CONCAT(last_name,', ',first_name,' ',middle_name)) LIKE CONCAT('%',SOUNDEX('$patname'),'%')
	//         OR  SOUNDEX(CONCAT(last_name,', ',middle_name,' ',first_name)) LIKE CONCAT('%',SOUNDEX('$patname'),'%')
	//         OR  SOUNDEX(CONCAT(last_name,', ',first_name,' ',middle_name)) LIKE '%$patname%'
	//         OR  SOUNDEX(CONCAT(last_name,', ',middle_name,' ',first_name)) LIKE '%$patname%'
	//         ORDER BY a.last_name ASC
	//         LIMIT 1000;
	//     ");
	//     return $result;
	// }

	// function getEntityByUnknownSingle($patname)
	// {
	//     $result = R::getAll("
	//         SELECT * FROM entity a WHERE SOUNDEX(CONCAT(last_name,', ',first_name,' ',middle_name)) LIKE CONCAT('%',SOUNDEX('$patname'),'%')
	//         OR  SOUNDEX(CONCAT(first_name,', ',middle_name,' ',last_name)) LIKE '%$patname%'
	//         OR  CONCAT(last_name,', ',first_name,' ',middle_name) LIKE '%$patname%'
	//         OR  CONCAT(first_name,', ',middle_name,' ',last_name) LIKE '%$patname%'
	//         ORDER BY a.last_name ASC
	//         LIMIT 1000;
	//     ");
	//     return $result;
	// }

	function getEntityByFirstName($patname)
	{
	    $result = R::getAll("
	        SELECT * FROM entity a WHERE CONCAT(last_name,', ',first_name,' ',middle_name) LIKE '%$patname%'
	        OR CONCAT(first_name,' ',middle_name, ' ', last_name) LIKE LIKE '%$patname%'
	        OR CONCAT(first_name,', ',last_name) LIKE '%$patname%'
	        OR CONCAT(first_name) LIKE '%$patname%'
	        ORDER BY a.last_name ASC
	        LIMIT 1000;
	    ");
	    return $result;
	}

	function getEntityByLastName($patname)
	{
	    $result = R::getAll("
	        SELECT * FROM entity a WHERE CONCAT(last_name,', ',first_name,' ',middle_name) LIKE '%$patname%'
	        OR  CONCAT(last_name,', ',middle_name,' ',first_name) LIKE '%$patname%'
	        OR  CONCAT(last_name,', ',first_name,' ',middle_name) LIKE '%$patname%'
	        OR  CONCAT(last_name,', ',middle_name,' ',first_name) LIKE '%$patname%'
	        ORDER BY a.last_name ASC
	        LIMIT 1000;
	    ");
	    return $result;
	}

	function getEntityByUnknownSingle($patname)
	{
	    $result = R::getAll("
	        SELECT * FROM entity a WHERE SOUNDEX(CONCAT(last_name,', ',first_name,' ',middle_name)) LIKE CONCAT('%',SOUNDEX('$patname'),'%')
	        OR  SOUNDEX(CONCAT(first_name,', ',middle_name,' ',last_name)) LIKE '%$patname%'
	        OR  CONCAT(last_name,', ',first_name,' ',middle_name) LIKE '%$patname%'
	        OR  CONCAT(first_name,', ',middle_name,' ',last_name) LIKE '%$patname%'
	        ORDER BY a.last_name ASC
	        LIMIT 1000;
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
		$id = R::findOne('entity','objid=?',[ $objid ])['id'];
	    $table = R::load( 'entity',$id);
	    $table->txnstatus = "VALIDATED";
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

