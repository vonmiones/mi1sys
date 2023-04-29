<?php
 /**
  * decrypt AES 256
  *
  * @param data $edata
  * @param string $password
  * @return decrypted data
  */
function decrypt($edata, $password) {
    $data = base64_decode($edata);
    $salt = substr($data, 0, 16);
    $ct = substr($data, 16);

    $rounds = 3; // depends on key length
    $data00 = $password.$salt;
    $hash = array();
    $hash[0] = hash('sha256', $data00, true);
    $result = $hash[0];
    for ($i = 1; $i < $rounds; $i++) {
        $hash[$i] = hash('sha256', $hash[$i - 1].$data00, true);
        $result .= $hash[$i];
    }
    $key = substr($result, 0, 32);
    $iv  = substr($result, 32,16);

    return openssl_decrypt($ct, 'AES-256-CBC', $key, true, $iv);
  }

/**
 * crypt AES 256
 *
 * @param data $data
 * @param string $password
 * @return base64 encrypted data
 */
function encrypt($data, $password) {
    // Set a random salt
    $salt = openssl_random_pseudo_bytes(16);

    $salted = '';
    $dx = '';
    // Salt the key(32) and iv(16) = 48
    while (strlen($salted) < 48) {
      $dx = hash('sha256', $dx.$password.$salt, true);
      $salted .= $dx;
    }

    $key = substr($salted, 0, 32);
    $iv  = substr($salted, 32,16);

    $encrypted_data = openssl_encrypt($data, 'AES-256-CBC', $key, true, $iv);
    return base64_encode($salt . $encrypted_data);
}

class EncryptedSessionHandler extends SessionHandler
{
    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function read($id)
    {
        $data = parent::read($id);

        if (!$data) {
            return "";
        } else {
            return decrypt($data, $this->key);
        }
    }

    public function write($id, $data)
    {
        $data = encrypt($data, $this->key);

        return parent::write($id, $data);
    }
}

// we'll intercept the native 'files' handler, but will equally work
// with other internal native handlers like 'sqlite', 'memcache' or 'memcached'
// which are provided by PHP extensions.
// ini_set('session.save_handler', 'files');
// $key = "Z8oEw2jAN/V9GxzjlVSw6xYN76xlFUC7mRFKoUw9oCj6sUEdtejWdq6cz0+HcG9X";
// $handler = new EncryptedSessionHandler($key);
// session_set_save_handler($handler, true);
// session_start();

// proceed to set and retrieve values by key from $_SESSION


/**
 * CREATED : DECEMBER 25, 2020
 * AUTHOR  : VON MIONES
 * SECURITY ISSUE #1:
 * 
 * ISSUES: 
 *      - LOGIN SESSION IS DELEGATED TO SERVER, THUS REQUIRING 
 *        HIGH MEMORY CONSUMPTION IN THE FUTURE
 *      - USERS CAN RECREATE/COPY SESSION FROM THEIR SIDE
 *      - RAW SESSION
 *      - SLOWER DATA RETRIEVAL
 * 
 * TODO:
 * 
 *      - FIX THIS TO DELEGATE LOGIN SESSION TO CLIENT
 *      - INSTEAD OF SERVER
 *      - USE: COOKIE 
 *      - TO COMPARE SESSION AND COOKIE
 *      - IS SESSION IS DIFFERENT FROM COOKIE
 *      - TERMINATE
 * 
 * 
 * SECURITY ISSUE #2:
 *      -   ACCESS TO API IS LIMITED DUE TO TIME CONSTRAINTS
 *      -   ENCRYPTION/AUTHENTICATION TOKENS
 *      -   CACHING
 * 
 * TODO:
 *      -   API MUST NOT BE TIME LIMITED, PROVIDING THE LOGIN
 *          TOKENS IS VALID
 *      -   CACHING MUST ALSO BE PROVIDED AT THE CLIENT SIDE FOR FASTER
 *          DATA RETRIEVAL
 * 
 */

// $duration = (1 * 10);
// $time= "";
// if(isset($_SESSION['started']))
// {
//     // show banner and hide form

//     $showform = 0;
//     $time = ($duration - (time() - $_SESSION['started']));
//     if($time <= 0)
//     {
//         unset($_SESSION['count']);
//         unset($_SESSION['offender']);
//         $showform == 1;
//         echo "You have been logged out";
//     }
// }
// else
// {
//   $_SESSION['started'] = time();
//   echo "Welcome";
//   die();
// }
// if ($time > 0) {
//       die("Logged In");
// }


function generateShortSession()
{
    ini_set('session.save_handler', 'files');
    $key = "Z8oEw2jAN/V9GxzjlVSw6xYN76xlFUC7mRFKoUw9oCj6sUEdtejWdq6cz0+HcG9X";
    $handler = new EncryptedSessionHandler($key);
    session_set_save_handler($handler, true);
    session_start();
}

function generateLongSession($duration = 1)
{
    ini_set('session.save_handler', 'files');
    $key = "Z8oEw2jAN/V9GxzjlVSw6xYN76xlFUC7mRFKoUw9oCj6sUEdtejWdq6cz0+HcG9X";
    $handler = new EncryptedSessionHandler($key);
    session_set_save_handler($handler, true);
    session_start();

    $duration = ($duration * 60);
    $time= "";
    if(isset($_SESSION['started']))
    {
        // show banner and hide form

        $showform = 0;
        $time = ($duration - (time() - $_SESSION['started']));
        if($time <= 0)
        {
            unset($_SESSION['count']);
            unset($_SESSION['offender']);
            $showform == 1;
            echo "You have been logged out";
        }
    }
    else
    {
      $_SESSION['started'] = time();
      echo "Welcome";
      die();
    }
    if ($time > 0) {
          die("Logged In");
    }
}