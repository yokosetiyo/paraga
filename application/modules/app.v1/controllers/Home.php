<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/App_Controller.php';

class Home extends App_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['extra_js'] = 'pages/home_js';
		$this->template->app('pages/home', $this->data);
	}
}