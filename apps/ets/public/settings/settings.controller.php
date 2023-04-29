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
		R::addDatabase('SOCIALENTITY','mysql:host='.SYSTEMDBHOST.';dbname='.SYSTEMDBNAME.'_ets',SYSTEMDBUSER, SYSTEMDBPASS );
		R::close();
	}


	function addEquipmentCategory($data)
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

