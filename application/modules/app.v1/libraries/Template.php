<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Template
{
	/***********************************
    
	 * Method : login
    
	 * @params : view, data
    
	 * description : load partial page for login
    
	 ************************************/

	public function login($view = null, $data = null)
	{
		$ci = &get_instance();
		$ci->load->view('components/partial/login/v_header', $data);
		$ci->load->view('/' . $view, $data);
		$ci->load->view('components/partial/login/v_footer', $data);
	}

	/***********************************
    
	 * Method : app
    
	 * @params : view, data
    
	 * description : load partial page for app
    
	 ************************************/

	public function app($view = null, $data = null)
	{
		$ci = &get_instance();
		$ci->load->view('components/partial/template/header', $data);
		$ci->load->view('components/partial/template/sidebar', $data);
		$ci->load->view('/' . $view, $data);
		$ci->load->view('components/partial/template/footer', $data);
	}

	/***********************************
    
	 * Method : display
    
	 * @params : view, data
    
	 * description : load partial page for display
    
	 ************************************/

	 public function display($view = null, $data = null)
	 {
		 $ci = &get_instance();
		 $ci->load->view('components/partial/display/v_header', $data);
		 $ci->load->view('components/partial/display/v_topbar', $data);
		 $ci->load->view('/' . $view, $data);
		 $ci->load->view('components/partial/display/v_footer', $data);
	 }
}