<?php 
 if (!defined('BASEPATH')) exit('No direct script access allowed');


// This is the one and only public include file for uLogin.
// Include it once on every authentication and for every protected page.

require_once(APPPATH . 'third_party/ulogin/ulogin/config/all.inc.php');
require_once(APPPATH . 'third_party/ulogin/ulogin/main.inc.php');

/*Auto load thirdparty classes*/
require_once(ULOGIN_PATH."/uLogin.inc.php");
require_once(ULOGIN_PATH."/config/all.inc.php");
require_once(ULOGIN_PATH."/main.inc.php");


//use a single variable for authentication
        

// Start a secure session if none is running
if (!sses_running())
    sses_start();

// We define some functions to log in and log out,
// as well as to determine if the user is logged in.
// This is needed because uLogin does not handle access control
// itself.

function isAppLoggedIn() {
    
    return isset($_SESSION['uid']) && isset($_SESSION['username']) && isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] === true);
}



?>