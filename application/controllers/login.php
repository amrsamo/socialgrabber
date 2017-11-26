<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public $isLoggedIn = false;
	public $data = array();

	public function __construct()
	{
	    parent::__construct();

	    if($this->checkLogin())
	    	redirect('home');
	}

	public function index()
	{

		$this->load->view('login',$this->data);
	}

	public function try()
	{
		
		if(!$_POST)
			redirect('login');

		$username = $_POST['username'];
		$password = $_POST['password'];

		$login_process = $this->Admin_User->checkLogin($username,$password);

		if($login_process == false)
		{
			$this->data['error'] = 'Login Failed';
			$this->load->view('login',$this->data);
			return;
		}

		$this->beginSession($login_process);
		

	}


	public function beginSession($data)
	{
		$this->session->set_userdata('username',$data->username);
		redirect('home');
	}

	public function checkLogin()
	{
		// $this->session->sess_destroy();
		if(isset($this->session->userdata['username']))
		{
			$username = $this->session->userdata['username'];
			$user_check = $this->Admin_User->checkUsername($username);
			if($user_check)
			{
				$this->isLoggedIn = true;
				$this->data['isLoggedIn'] = true;
				$this->data['admin'] = $user_check;
				$this->data['admin_id'] = $this->data['admin'][0]->id;
				return true;
			}
		}
		
		$this->isLoggedIn = false;
		$this->data['isLoggedIn'] = false;
		return false;
		
		
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */