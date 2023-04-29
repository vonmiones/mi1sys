<?php
/**
 * TokenizeName Class
 * Convert Conventional Form Name to Tokenized Format 
 * 
 */
class NameTokenizer
{

	function __construct()
	{
		
	}
	function FormName($name,$method="encrypt")
	{
		$result = "error";
		$cipherMethod = "AES-128-CTR";
		// $cipherMethod = "AES-256-CBC";
		$ivLength = openssl_cipher_iv_length($cipherMethod);
		$options = 0;
		$secret_iv = '0329198712112021'; // Updateable dob mdy created
  
		// Store the encryption key
		$key = hash('sha256', "Z8oEw2jAN/V9GxzjlVSw6xYN76xlFUC7mRFKoUw9oCj6sUEdtejWdq6cz0+HcG9X");
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		if ($method == "decrypt") {
			$result  = substr(openssl_decrypt($name, $cipherMethod, 
					        $key , $options, $iv),0,strlen($name));  
		}else{
			$result  = openssl_encrypt($name, $cipherMethod,
					            $key , $options, $iv);
		}
		return $result;
	}
}

