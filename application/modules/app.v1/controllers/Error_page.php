<?php defined('BASEPATH') or exit('No direct script access allowed');

class Error_page extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function access_denied()
    {
        $this->load->view('pages/access_denied');
    }
}