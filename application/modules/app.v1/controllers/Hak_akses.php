<?php defined('BASEPATH') or exit('No direct script access allowed');

class Hak_akses extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->checkPermission();
    }

    public function index()
    {
        $data = array(
            'extra_js' => 'pages/hak_akses/index_js'
        );
        $this->template->app('pages/hak_akses/index', $data);
    }

    public function atur_akses($ROLE_ID)
    {
        $data = array(
            'ROLE_ID' => $ROLE_ID,
            'extra_js' => 'pages/hak_akses/atur_akses_js'
        );
        $this->template->app('pages/hak_akses/atur_akses', $data);
    }

    public function tambah()
    {
        $data = [];
        $this->load->view('pages/hak_akses/form', $data, FALSE);
    }

    public function ubah()
    {
        $data = [];
        $this->load->view('pages/hak_akses/form', $data, FALSE);
    }
}