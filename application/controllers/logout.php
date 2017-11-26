<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public $isLoggedIn = false;
	public $data = array();

	public function __construct()
	{
	    parent::__construct();
	    $this->session->sess_destroy();
	    $this->session->unset_userdata('username');
	    redirect('login');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */