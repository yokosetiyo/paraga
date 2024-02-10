<?php defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->checkPermission();
    }

    public function index()
    {
        $data = array(
            'extra_js' => 'pages/user/index_js'
        );
        $this->template->app('pages/user/index', $data);
    }

    public function tambah()
    {
        $data = [];
        $this->load->view('pages/user/form', $data, FALSE);
    }
    
    public function ubah()
    {
        $data = [];
        $this->load->view('pages/user/form', $data, FALSE);
    }
}