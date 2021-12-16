/*Author: Alfred Ntiamoah
Company: New Age Developers Group
Email: antiamoah890@gmail.com
website: natlink.net
License: Proprietary license
All Right Reserved (2017)*/


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
 
// Extend the TCPDF class to create custom Header and Footer
class OnemoretakePDF extends TCPDF {
}
 
function tcpdf(){
    return new OnemoretakePDF (PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);
}
 
?>