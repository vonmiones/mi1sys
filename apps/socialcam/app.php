<?php  
/**
 * @Name : Social Works - Cash Assistance Module
 * @app : socialcam
 * @Author : Von Microbert T. Miones
 * @Website : fb.com/vonmiones
 * @Email : vonmiones@gmail.com
 * @Number : 09488502995
 * @DateCreated : 01/10/2021
 * @Method : WebApp
 * @Version : 1.0.0.1 beta
 */
class mi1_apps_socialcam
{
	
	function __construct($access="public")
	{

		$mdetect = new MobileDetect(); 

		if($mdetect->isMobile()){ 
		    // Detect mobile/tablet  
		    if($mdetect->isTablet()){ 
		        // echo 'Tablet Device Detected!<br/>'; 
				if ($access == "admin") {
					require 'admin/index.php';
				}else{
					require 'tablet/index.php';
				}		        
		    }else{ 
		        // echo 'Mobile Device Detected!<br/>'; 
		        if ($access == "admin") {
					require 'admin/index.php';
				}else{
					require 'mobile/index.php';
				}	
		    } 
		     
		    // Detect platform 
		    if($mdetect->isiOS()){ 
		        // echo 'IOS'; 
		    }elseif($mdetect->isAndroidOS()){ 
		        // echo 'ANDROID'; 
		    } 
		}else{ 
		    // echo 'Desktop Detected!'; 
			if ($access == "admin") {
				require 'admin/index.php';
			}else{
				require 'public/index.php';
			}
		}

	}
	
	function Test()
	{
	}
}




?>