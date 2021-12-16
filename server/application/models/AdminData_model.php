<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *
 * *This class should only display the footer and header of the page
 * *Angular will load the rest of the page
 * *An application can have several layouts 
 * * */

class AdminData_model extends CI_Model {

    public $groups;
    public $permissions;
    public $users;

    public function __construct() {
        parent:: __construct();
    }

}




