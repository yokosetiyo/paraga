<?php defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->checkPermission();
    }

    public function index()
    {
        $data = array(
            'extra_js' => 'pages/menu/index_js'
        );
        $this->template->app('pages/menu/index', $data);
    }

    public function tambah()
    {
        $data = [];
        $this->load->view('pages/menu/form', $data, FALSE);
    }

    public function ubah()
    {
        $data = [];
        $this->load->view('pages/menu/form', $data, FALSE);
    }
}