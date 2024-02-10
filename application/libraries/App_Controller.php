<?php defined('BASEPATH') OR exit('No direct script access allowed');

class App_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

		// Check session
		check_user_session();
    }
}