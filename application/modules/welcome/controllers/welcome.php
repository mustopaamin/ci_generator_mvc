<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data['title']		= 'Welcome to CodeIgniter';
		$data['content']	= 'welcome_message';
		$this->load->view('layout/main',$data);
	}

	public function blank()
	{
		$data['title']		= 'AdminLTE 2 | Blank Page';
		$data['content']	= 'layout/blank';
		$this->load->view('layout/main',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
