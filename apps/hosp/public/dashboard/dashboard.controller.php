<?php
global $redis;
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
		R::addDatabase('HOSPITAL','mysql:host=192.168.2.4;dbname=hospital_dbo','sa','R00t' );
		R::close();
	}

	function getAdmissionByID($id)
	{
		global $redis;
		R::close();
		R::selectDatabase('HOSPITAL');
	    $query = "SELECT * FROM hadmlog WHERE hpercode = '$id' ORDER BY admdate DESC;";
		$ckey= 'ad_' . preg_replace('/[^a-zA-Z0-9\']/', '', $id);
		
		$cached = $redis->get($ckey);

		// die("$cached");
	    $data =array("source"=>"raw","data"=>R::getAll($query));
		// die(json_encode($data['source']));
	    return $data;

	}

	function getOPDConsultationByID($id)
	{
		global $redis;
		R::close();
		R::selectDatabase('HOSPITAL');
	    $query = "SELECT * FROM hopdlog WHERE hpercode = '$id' ORDER BY opddate DESC;";
		$ckey= 'opd_' . preg_replace('/[^a-zA-Z0-9\']/', '', $id);

		$cached = $redis->get($ckey);
		if ($cached == true && isset($cached)) {
		    $data = array("source"=>"cache","data"=>json_decode($cached,true));		
		} else {
		    $data =array("source"=>"raw","data"=>R::getAll($query));
		}
		// die(json_encode($data));
	    return $data;
	}

	function getPersonnelID($id)
	{
		global $redis;
		R::close();
		R::selectDatabase('HOSPITAL');
	    $query = "SELECT * FROM hpersonal WHERE employeeid = '$id';";

		$ckey= 'q_' . strtolower($id);
		$cached = $redis->get($ckey);

		if ($cached == true) {
		    $data = array("source"=>"cache","data"=>json_decode($cached,true));		
		} else {
			$result = R::getAll($query);
		    $data =array("source"=>"raw","data"=>$result);
		    $redis->set( 'q_' . strtolower(preg_replace('/[^a-zA-Z0-9\']/', '', $id)), json_encode($result));
		}
	    return $data;
	}


	function getEntityByID($id)
	{
		global $redis;
		R::close();
		R::selectDatabase('HOSPITAL');
	    $query = "SELECT * FROM hperson WHERE hpercode = '$id';";

		$ckey= 'q_' .preg_replace('/[^a-zA-Z0-9\']/', '', $id);
		$cached = $redis->get($ckey);

		if ($cached == true) {
		    $data = array("source"=>"cache","data"=>json_decode($cached,true));		
		} else {
		    $data =array("source"=>"raw","data"=>R::getAll($query));
		}
		// die("Function: $ckey getEntityByID " . json_encode($data));
		// var_dump($data);
		// die();
	    return $data;
	}

	function getDuplicateByName($patname)
	{
		global $redis;
		R::close();
		R::selectDatabase('HOSPITAL');
	    $query = "
	    		SELECT * FROM hperson 
	    		WHERE 
	    			SOUNDEX(CONCAT(patlast, ', ' , patfirst, ' ' , patmiddle, ' ' , patsuffix)) = SOUNDEX('$patname')
	    		OR	CONCAT(patlast, ', ' , patfirst, ' ' , patmiddle, ' ' , patsuffix) = '$patname'

	    			;";

		$ckey= 'q_' . $id;
		$cached = $redis->get($ckey);

		if ($cached == true) {
		    $data = array("source"=>"cache","data"=>json_decode($cached,true));		
		} else {
		    $data =array("source"=>"raw","data"=>R::getAll($query));
		}
	    return $data;
	}

	function getEntityByFirstName($patname)
	{
	    $result = R::getAll("
	        SELECT * FROM entity a WHERE 
	        	SOUNDEX(CONCAT(patfirst,' ',patmiddle,' ', patlast, ' ' , patsuffix)) = SOUNDEX('%$patname%')
	        OR	SOUNDEX(CONCAT(patfirst,' ',patmiddle,' ', patlast, ',' , patsuffix)) = SOUNDEX('%$patname%')
	        OR 	SOUNDEX(CONCAT(patfirst,' ',patmiddle,' ', patlast)) = SOUNDEX('%$patname%')
	        ORDER BY a.patlast ASC
	        LIMIT 1000;
	    ");
	    return $result;
	}

	function getEntityByLastName($patname)
	{
	    $result = R::getAll("
	        SELECT * FROM entity a WHERE 
				SOUNDEX(CONCAT(patlast,' ',patfirst,' ', patmiddle)) = SOUNDEX('%$patname%')
			OR	SOUNDEX(CONCAT(patlast,', ',patfirst,' ', patmiddle)) = SOUNDEX('%$patname%')
	        ORDER BY a.patlast ASC
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
	// 		array_push($qArray, " OR (SOUNDEX(CONCAT(patlast)) = SOUNDEX('%$key%')  AND ( txncode IS NULL OR txncode = 0 ) )");
	// 		array_push($qArray, " OR (SOUNDEX(CONCAT(patfirst)) = SOUNDEX('%$key%')  AND ( txncode IS NULL OR txncode = 0 ) )");
	// 		array_push($qArray, " OR (SOUNDEX(CONCAT(patmiddle)) = SOUNDEX('%$key%')  AND ( txncode IS NULL OR txncode = 0 ) )");
	// 	}
	// 	$q = implode(' ',$qArray);
	//     $result = R::getAll("
	//          SELECT * FROM entity a WHERE 
	//         	(SOUNDEX(CONCAT(patfirst,' ',patmiddle,' ', patlast)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  (SOUNDEX(CONCAT(patlast,' ',patfirst,' ', patmiddle)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  (SOUNDEX(CONCAT(patlast,', ',patfirst,' ', patmiddle)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  (SOUNDEX(CONCAT(patfirst,' ', patlast)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  (SOUNDEX(CONCAT(patlast,' ', patfirst)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  (SOUNDEX(CONCAT(patlast)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  (SOUNDEX(CONCAT(patfirst)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  (SOUNDEX(CONCAT(patmiddle)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		$q
	//         ORDER BY a.patlast ASC
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
	// 		array_push($qArray, " OR ( SOUNDEX(patlast) = SOUNDEX('%$key%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patfirst) = SOUNDEX('%$key%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patmiddle) = SOUNDEX('%$key%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 	}
	// 	foreach ($rsplit as $key) {
	// 		array_push($qArray, " OR ( SOUNDEX(patlast) = SOUNDEX('%$key%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patfirst) = SOUNDEX('%$key%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patmiddle) = SOUNDEX('%$key%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 	}

	// 	if (count($split) > 1) {
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(patfirst,' ' , patlast)) = SOUNDEX('%".$split[1].' '.$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(patfirst,' ' , patmiddle)) = SOUNDEX('%".$split[1].' '.$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(patlast,' ' , patfirst)) = SOUNDEX('%".$split[0].' '.$split[1]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(patlast,' ' , patmiddle)) = SOUNDEX('%".$split[1].' '.$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(patmiddle,' ' , patfirst)) = SOUNDEX('%".$split[0].' '.$split[1]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(patmiddle,' ' , patlast)) = SOUNDEX('%".$split[1].' '.$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patfirst) = SOUNDEX('%".$split[0].' '.$split[1]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patfirst) = SOUNDEX('%".$split[1].' '.$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patlast) = SOUNDEX('%".$split[0].' '.$split[1]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patlast) = SOUNDEX('%".$split[1].' '.$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patmiddle) = SOUNDEX('%".$split[0].' '.$split[1]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patmiddle) = SOUNDEX('%".$split[1].' '.$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 	}else{
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(patfirst,' ' , patlast)) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(patfirst,' ' , patmiddle)) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(patlast,' ' , patfirst)) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(patlast,' ' , patmiddle)) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(patmiddle,' ' , patfirst)) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(CONCAT(patmiddle,' ' , patlast)) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patfirst) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patfirst) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patlast) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patlast) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 		array_push($qArray, " OR ( SOUNDEX(patmiddle) = SOUNDEX('%".$split[0]."%') AND ( txncode IS NULL OR txncode = 0 ) ) ");
	// 	}

		
	// 	$q = implode(' ',$qArray);

	//     $result = R::getAll("
	//          SELECT * FROM entity a WHERE 
	//         	( SOUNDEX(CONCAT(patfirst,' ',patmiddle,' ', patlast)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(CONCAT(patlast,' ',patfirst,' ', patmiddle)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(CONCAT(patlast,', ',patfirst,' ', patmiddle)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(CONCAT(patfirst,' ', patlast)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(CONCAT(patlast,' ', patfirst)) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(patlast) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(patfirst) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(patmiddle) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(fullname_last) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		OR  ( SOUNDEX(fullname_first) = SOUNDEX('%$patname%') AND ( txncode IS NULL OR txncode = 0 ) )
	// 		$q;
	//     ");
	//     return $result;
	// }

	/**
	 * REMINDER:  
	 * 	- Get all keys from redis
	 *	- use Fuzzy/Levenhestien Algorithm to match keys 
	 *	- get specific keys without using redundancy of data
	 * 	- load data
	 * 	- retrieve
	 */

	// function getEntityByUnknownSingle($patname, $cachekey)
	// {
	// 	global $redis;
	// 	R::close();
	// 	R::selectDatabase('HOSPITAL');
	// 	$split = explode(' ', $patname);
	// 	$rsplit = array_reverse($split);
	// 	$qArray = [];
	// 	$q = '';

	// 	foreach ($split as $key) {
	// 		array_push($qArray, " OR SOUNDEX(patlast) = SOUNDEX('%$key%') ");
	// 		array_push($qArray, " OR SOUNDEX(patfirst) = SOUNDEX('%$key%') ");
	// 		array_push($qArray, " OR SOUNDEX(patmiddle) = SOUNDEX('%$key%') ");
	// 	}
	// 	foreach ($rsplit as $key) {
	// 		array_push($qArray, " OR SOUNDEX(patlast) = SOUNDEX('%$key%') ");
	// 		array_push($qArray, " OR SOUNDEX(patfirst) = SOUNDEX('%$key%') ");
	// 		array_push($qArray, " OR SOUNDEX(patmiddle) = SOUNDEX('%$key%') ");
	// 	}

	// 	if (count($split) > 1) {
	// 		array_push($qArray, " OR SOUNDEX(CONCAT(patfirst,' ' , patlast)) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(CONCAT(patfirst,' ' , patmiddle)) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(CONCAT(patlast,' ' , patfirst)) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(CONCAT(patlast,' ' , patmiddle)) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(CONCAT(patmiddle,' ' , patfirst)) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(CONCAT(patmiddle,' ' , patlast)) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(patfirst) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(patfirst) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(patfirst) = SOUNDEX('%".$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(patfirst) = SOUNDEX('%".$split[1]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(patlast) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(patlast) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(patmiddle) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(patmiddle) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
	// 		array_push($qArray, " OR patfirst LIKE '%".$split[0]."%' ");
	// 		array_push($qArray, " OR patlast LIKE '%".$split[0]."%' ");
	// 		array_push($qArray, " OR patmiddle LIKE '%".$split[0]."%' ");
	// 		array_push($qArray, " OR patfirst LIKE '%".$split[1]."%' ");
	// 		array_push($qArray, " OR patlast LIKE '%".$split[1]."%' ");
	// 		array_push($qArray, " OR patmiddle LIKE '%".$split[1]."%' ");
	// 		array_push($qArray, " OR hpercode = '".$split[0]."' ");

	// 	}else{
	// 		array_push($qArray, " OR SOUNDEX(CONCAT(patfirst,' ' , patlast)) = SOUNDEX('%".$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(CONCAT(patfirst,' ' , patmiddle)) = SOUNDEX('%".$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(CONCAT(patlast,' ' , patfirst)) = SOUNDEX('%".$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(CONCAT(patlast,' ' , patmiddle)) = SOUNDEX('%".$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(CONCAT(patmiddle,' ' , patfirst)) = SOUNDEX('%".$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(CONCAT(patmiddle,' ' , patlast)) = SOUNDEX('%".$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(patfirst) = SOUNDEX('%".$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(patlast) = SOUNDEX('%".$split[0]."%') ");
	// 		array_push($qArray, " OR SOUNDEX(patmiddle) = SOUNDEX('%".$split[0]."%') ");
	// 		array_push($qArray, " OR patfirst LIKE '%".$split[0]."%' ");
	// 		array_push($qArray, " OR patlast LIKE '%".$split[0]."%' ");
	// 		array_push($qArray, " OR patmiddle LIKE '%".$split[0]."%' ");
	// 		array_push($qArray, " OR hpercode = '".$split[0]."' ");
	// 	}

	// 	$q = implode(' ',$qArray);

	// 	$query = "SELECT * FROM hperson WHERE 
	//         	SOUNDEX(CONCAT(patfirst,' ',patmiddle,' ', patlast)) = SOUNDEX('%$patname%')
	//         OR 	SOUNDEX(CONCAT(patfirst,patmiddle,patlast)) = SOUNDEX('%$patname%')
	// 		OR 	SOUNDEX(CONCAT(patlast,' ',patfirst,' ', patmiddle)) = SOUNDEX('%$patname%')
	// 		OR 	SOUNDEX(CONCAT(patlast,', ',patfirst,' ', patmiddle)) = SOUNDEX('%$patname%')
	// 		OR 	SOUNDEX(CONCAT(patlast,',',patfirst,' ', patmiddle)) = SOUNDEX('%$patname%')
	// 		OR 	SOUNDEX(CONCAT(patlast,patfirst,patmiddle)) = SOUNDEX('%$patname%')
	// 		OR 	SOUNDEX(CONCAT(patfirst,' ', patlast)) = SOUNDEX('%$patname%')
	// 		OR 	SOUNDEX(CONCAT(patfirst, patlast)) = SOUNDEX('%$patname%')
	// 		OR 	SOUNDEX(CONCAT(patlast,' ', patfirst)) = SOUNDEX('%$patname%')
	// 		OR 	SOUNDEX(CONCAT(patlast,patfirst)) = SOUNDEX('%$patname%')
	// 		OR 	SOUNDEX(patlast) = SOUNDEX('%$patname%')
	// 		OR 	SOUNDEX(patfirst) = SOUNDEX('%$patname%')
	// 		OR 	SOUNDEX(patmiddle) = SOUNDEX('%$patname%')
	// 		OR 	SOUNDEX(REPLACE(patlast,'-','')) = SOUNDEX('$patname')
	// 		OR 	REPLACE(patlast,'-','') LIKE '%$patname%'
	// 		OR 	patlast SOUNDS LIKE '$patname'
	// 		OR 	patfirst SOUNDS LIKE '$patname'
	// 		OR 	patmiddle SOUNDS LIKE '$patname'
	// 		OR 	patlast LIKE '%$patname%'
	// 		OR 	patfirst LIKE '%$patname%'
	// 		OR 	patmiddle LIKE '%$patname%'
	// 		OR 	hpercode = '$patname'
	// 		$q;";


	// 	// die($query);

	// 	// Check if the query result is in the cache
	// 	// $key = 'q_' . md5($query);
	// 	$patname = preg_replace('/[^a-zA-Z0-9\']/', '', $patname);
	// 	// $patname = str_replace(' ','',$patname);
	// 	// $patname = str_replace('-','',$patname);
	// 	// $patname = str_replace("'",'',$patname);
	// 	// $patname = str_replace(",",'',$patname);
	// 	// $patname = str_replace(";",'',$patname);
	// 	// $patname = str_replace("\\",'',$patname);
	// 	// $patname = str_replace("/",'',$patname);
	// 	// $patname = str_replace("(",'',$patname);
	// 	// $patname = str_replace(")",'',$patname);
	// 	$key = 'q_' . $patname;

	// 	$pcachkey =preg_replace('/[^a-zA-Z0-9\']/', '', $cachekey);
	// 	// $pcachkey = str_replace(' ','',$cachekey);
	// 	// $pcachkey = str_replace('-','',$pcachkey);
	// 	// $pcachkey = str_replace("'",'',$pcachkey);
	// 	// $pcachkey = str_replace(",",'',$pcachkey);
	// 	// $pcachkey = str_replace(";",'',$pcachkey);
	// 	// $pcachkey = str_replace("\\",'',$pcachkey);
	// 	// $pcachkey = str_replace("/",'',$pcachkey);
	// 	// $pcachkey = str_replace("(",'',$pcachkey);
	// 	// $pcachkey = str_replace(")",'',$pcachkey);
	// 	$ckey= 'q_' .  strtolower(preg_replace('/[^a-zA-Z0-9\']/', '', $pcachkey));

	// 	// echo $ckey;
	// 	// $cached = $redis->get($key);
	// 	$cached = $redis->get($ckey);

	// 	if ($cached == true) {
	// 	    // Return the cached result
	// 	    $data = array("source"=>"cache","data"=>json_decode($cached,true));		
	// 	} else {
	// 	    $data =array("source"=>"raw","data"=>R::getAll($query));
	// 	}
	// 	// var_dump($data);
	// 	// die();
	//     return $data;
	// }


	function getEntityByUnknownSingle($patname, $cachekey)
	{
		global $redis;
		R::close();
		R::selectDatabase('HOSPITAL');
		$split = explode(' ', $patname);
		$rsplit = array_reverse($split);
		$qArray = [];
		$q = '';

		foreach ($split as $key) {
			array_push($qArray, " OR SOUNDEX(patlast) = SOUNDEX('%$key%') ");
			array_push($qArray, " OR SOUNDEX(patfirst) = SOUNDEX('%$key%') ");
			array_push($qArray, " OR SOUNDEX(patmiddle) = SOUNDEX('%$key%') ");
		}
		foreach ($rsplit as $key) {
			array_push($qArray, " OR SOUNDEX(patlast) = SOUNDEX('%$key%') ");
			array_push($qArray, " OR SOUNDEX(patfirst) = SOUNDEX('%$key%') ");
			array_push($qArray, " OR SOUNDEX(patmiddle) = SOUNDEX('%$key%') ");
		}

		if (count($split) > 1) {
			array_push($qArray, " OR SOUNDEX(CONCAT(patfirst,' ' , patlast)) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(patfirst,' ' , patmiddle)) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(patlast,' ' , patfirst)) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(patlast,' ' , patmiddle)) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(patmiddle,' ' , patfirst)) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(patmiddle,' ' , patlast)) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(patfirst) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
			array_push($qArray, " OR SOUNDEX(patfirst) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(patfirst) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(patfirst) = SOUNDEX('%".$split[1]."%') ");
			array_push($qArray, " OR SOUNDEX(patlast) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
			array_push($qArray, " OR SOUNDEX(patlast) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(patmiddle) = SOUNDEX('%".$split[0].' '.$split[1]."%') ");
			array_push($qArray, " OR SOUNDEX(patmiddle) = SOUNDEX('%".$split[1].' '.$split[0]."%') ");
			array_push($qArray, " OR patfirst LIKE '%".$split[0]."%' ");
			array_push($qArray, " OR patlast LIKE '%".$split[0]."%' ");
			array_push($qArray, " OR patmiddle LIKE '%".$split[0]."%' ");
			array_push($qArray, " OR patfirst LIKE '%".$split[1]."%' ");
			array_push($qArray, " OR patlast LIKE '%".$split[1]."%' ");
			array_push($qArray, " OR patmiddle LIKE '%".$split[1]."%' ");
			array_push($qArray, " OR hpercode = '".$split[0]."' ");

		}else{
			array_push($qArray, " OR SOUNDEX(CONCAT(patfirst,' ' , patlast)) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(patfirst,' ' , patmiddle)) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(patlast,' ' , patfirst)) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(patlast,' ' , patmiddle)) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(patmiddle,' ' , patfirst)) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(CONCAT(patmiddle,' ' , patlast)) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(patfirst) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(patlast) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR SOUNDEX(patmiddle) = SOUNDEX('%".$split[0]."%') ");
			array_push($qArray, " OR patfirst LIKE '%".$split[0]."%' ");
			array_push($qArray, " OR patlast LIKE '%".$split[0]."%' ");
			array_push($qArray, " OR patmiddle LIKE '%".$split[0]."%' ");
			array_push($qArray, " OR hpercode = '".$split[0]."' ");
		}

		$q = implode(' ',$qArray);

		$query = "SELECT * FROM hperson WHERE 
	        	SOUNDEX(CONCAT(patfirst,' ',patmiddle,' ', patlast)) = SOUNDEX('%$patname%')
	        OR 	SOUNDEX(CONCAT(patfirst,patmiddle,patlast)) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(CONCAT(patlast,' ',patfirst,' ', patmiddle)) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(CONCAT(patlast,', ',patfirst,' ', patmiddle)) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(CONCAT(patlast,',',patfirst,' ', patmiddle)) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(CONCAT(patlast,patfirst,patmiddle)) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(CONCAT(patfirst,' ', patlast)) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(CONCAT(patfirst, patlast)) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(CONCAT(patlast,' ', patfirst)) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(CONCAT(patlast,patfirst)) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(patlast) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(patfirst) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(patmiddle) = SOUNDEX('%$patname%')
			OR 	SOUNDEX(REPLACE(patlast,'-','')) = SOUNDEX('$patname')
			OR 	REPLACE(patlast,'-','') LIKE '%$patname%'
			OR 	patlast SOUNDS LIKE '$patname'
			OR 	patfirst SOUNDS LIKE '$patname'
			OR 	patmiddle SOUNDS LIKE '$patname'
			OR 	patlast LIKE '%$patname%'
			OR 	patfirst LIKE '%$patname%'
			OR 	patmiddle LIKE '%$patname%'
			OR 	hpercode = '$patname'
			$q;";


		// die($query);

		// Check if the query result is in the cache
		// $key = 'q_' . md5($query);
		$patname = preg_replace('/[^a-zA-Z0-9\']/', '', $patname);
		// $patname = str_replace(' ','',$patname);
		// $patname = str_replace('-','',$patname);
		// $patname = str_replace("'",'',$patname);
		// $patname = str_replace(",",'',$patname);
		// $patname = str_replace(";",'',$patname);
		// $patname = str_replace("\\",'',$patname);
		// $patname = str_replace("/",'',$patname);
		// $patname = str_replace("(",'',$patname);
		// $patname = str_replace(")",'',$patname);
		$key = 'q_' . $patname;

		$pcachkey =preg_replace('/[^a-zA-Z0-9\']/', '', $cachekey);
		// $pcachkey = str_replace(' ','',$cachekey);
		// $pcachkey = str_replace('-','',$pcachkey);
		// $pcachkey = str_replace("'",'',$pcachkey);
		// $pcachkey = str_replace(",",'',$pcachkey);
		// $pcachkey = str_replace(";",'',$pcachkey);
		// $pcachkey = str_replace("\\",'',$pcachkey);
		// $pcachkey = str_replace("/",'',$pcachkey);
		// $pcachkey = str_replace("(",'',$pcachkey);
		// $pcachkey = str_replace(")",'',$pcachkey);
		$ckey= 'q_' .  strtolower(preg_replace('/[^a-zA-Z0-9\']/', '', $pcachkey));

		// echo $ckey;
		// $cached = $redis->get($key);
		$cached = $redis->get($ckey);

		if ($cached == true) {
		    // Return the cached result
		    $data = array("source"=>"cache","data"=>json_decode($cached,true));		
		} else {
		    $data =array("source"=>"raw","data"=>R::getAll($query));
		}
		// var_dump($data);
		// die();
	    return $data;
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

