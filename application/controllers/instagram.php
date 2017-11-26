<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Instagram extends CI_Controller {

	public $isLoggedIn = false;
	public $data = array();

	public function __construct()
	{
	    parent::__construct();

	    if(!$this->checkLogin())
	    	redirect('login');
	}

	public function index()
	{
		$this->load->view('home',$this->data);
	}



	public function users()
	{	

		$order = array();
		$order['by'] = 'id';
		$order['direction'] = 'desc';

		$this->data['users_count'] = $this->Instagram_User->getCount();

		if(isset($_GET['max']))
		{
			$max = $_GET['max'];
			$conditions = array();
			$conditions['id <'] = $max;
			$this->data['users'] = $this->Instagram_User->get($conditions,null,500,null,$order);
		}
		elseif(isset($_GET['username']))
		{	
			$conditions = array();
			$conditions['username'] = $_GET['username'];
			$this->data['users'] = $this->Instagram_User->get($conditions,null,500,null,$order);
		}
		else
		{
			$this->data['users'] = $this->Instagram_User->get(null,null,500,null,$order);
		}
		
		if(!empty($this->data['users']))
		$this->data['max_user_id'] = $this->data['users'][count($this->data['users'])-1]->id;
		

		// printme($this->data['users']);exit();

		$this->load->view('instagram/users',$this->data);
	}


	public function custom()
	{	
		$this->data['lists'] = $this->User_List->getCustomLists($this->data['admin'][0]->id);
		
		// printme($this->data);
		// exit();
		$this->load->view('lists',$this->data);
	}

	public function addusertofavorites()
	{	

		$list = $this->User_List->get(array('name'=>$_POST['list']))[0];
		$users = $list->users;
		if($users == "")
		{
			//Empty List
			$users = $_POST['user'];
			$input = array();
			$input['users'] = $users;
			$input['count'] = 1;
			$save = $this->User_List->update($input,array('name'=>$_POST['list']));
		}
		else
		{
			$users = $list->users;
			$users .= ','.$_POST['user'];
			$count = $list->count + 1;

			$input = array();
			$input['users'] = $users;
			$input['count'] = $count;
			$save = $this->User_List->update($input,array('name'=>$_POST['list']));
			// printme($users);
			// printme($list);
			// exit();
		}
		
	}

	public function customlist($list)
	{	


		if($list == 'favorites')
		{
		$this->data['list'] = $this->User_List->get(array('admin_id'=>$this->data['admin'][0]->id,'name'=>'favorites'));
		}
		elseif($list == 'curated')
		$this->data['list'] = $this->User_List->get(array('admin_id'=>$this->data['admin'][0]->id,'name'=>'curated'));
		else
		$this->data['list'] = $this->User_List->get(array('admin_id'=>$this->data['admin'][0]->id,'id'=>$list));




		$this->data['actions'] = $this->User_List->getListActions($this->data['admin'][0]->id,$list);


		if($this->data['list'][0]->count != 0)
		{
			$this->data['users'] = explode(',', $this->data['list'][0]->users);

			// if(count($this->data['users']) > 1)
			// unset($this->data['users'][count($this->data['users'])-1]);

				if(!empty($this->data['actions']))
			{
				//Update Users
				exit();
			}
			else
			{	
				$users = array();
				foreach ($this->data['users'] as $username) {
					$user = new stdClass();
					$user->username = $username;
					$user->export = 0;
					$users[] = $user;
				}
			}

			$this->data['users'] = $users;

		}
		
		
		

		$this->load->view('list',$this->data);
	}


	// public function lists()
	// {
	// 	echo 'here';
	// 	exit();
	// }


	public function profile($username)
	{
		$user = $this->Instagram_User->get(array('username'=>$username));


		
		if(empty($user))
			redirect('home');

		$this->data['user'] = $user[0];


		//CHECK IF USER IN FAVORITES OR CURATED
		$favorites = $this->User_List->get(array('name'=>'favorites','users like'=>$this->data['user']->username));
		if($favorites)
			$this->data['user']->favorites = 1;

		$curated = $this->User_List->get(array('name'=>'curated','users like'=>$this->data['user']->username));
		if($curated)
			$this->data['user']->curated = 1;


		$this->data['user_posts'] = $this->Instagram_Post->get(array('user_id'=>$this->data['user']->id));
		
		$total_likes = 0;
		$total_comments = 0;
		$output = array();

		foreach ($this->data['user_posts'] as $post) {

			$caption = $post->caption;
			$caption = explode('#', $caption);
			$post->caption_only = $caption[0];
			if($post->caption != "")
			$post->caption_hashtags = get_hashtags($post->caption , $str = 0);

			
			$comments = $this->Instagram_Comment->get(array('post_id'=>$post->id));
			$post->comments = $comments;
			$post->comments_count = count($comments);
			$output[] = $post;

			$total_likes    += $post->likes;
			$total_comments += count($comments);
		}

		//GET USER HASHTAGS
		$this->data['hashtags'] = $this->Instagram_Hashtag_User->getUserHashtags($this->data['user']->id);
		
		$this->data['location'] = $this->Instagram_Location_User->getUserCountryCity($this->data['user']->id);

		// printme($this->data);
		// exit();

		$this->data['user_posts'] = $output;
		$this->data['total_likes'] = $total_likes;
		$this->data['total_comments'] = $total_comments;
		// $this->data['locations'] = $locations;
		
		$this->data['avg_likes'] = $this->data['total_likes'] / 20 ;
		$this->data['avg_comments'] = $this->data['total_comments'] / 20 ;
		$this->data['engagement_rate'] = ($this->data['avg_likes'] +  $this->data['avg_comments']) / $this->data['user']->followers;
		$this->data['engagement_rate'] = $this->data['engagement_rate']*100;
		
		// printme($this->data);
		// exit();

		$this->load->view('instagram/profile',$this->data);
	}



	public function hashtags()
	{
		$this->data['top_hashtags'] = $this->Instagram_Hashtag->get("","",100,"",array('by'=>'count','direction'=>'desc'));
		$this->load->view('instagram/hashtags',$this->data);
	}

	public function hashtag($hashtag)
	{
		$this->data['hashtag'] = $this->Instagram_Hashtag->get(array("text"=>$hashtag))[0];

		$this->data['users'] = $this->Instagram_Hashtag_User->getHashtagsUsers($this->data['hashtag']->id);
		
		$this->load->view('instagram/hashtag',$this->data);
	}


	public function geolocations()
	{
		$this->data['top_locations'] = $this->Instagram_Location->get("","",100,"",array('by'=>'count','direction'=>'desc'));
		$this->load->view('instagram/locations',$this->data);
	}

	public function geolocation($location)
	{
		$this->data['location'] = $this->Instagram_Location->get(array("id"=>$location))[0];

		$this->data['users'] = $this->Instagram_Location_User->getLocationUsers($this->data['location']->id);
		
		$this->load->view('instagram/location',$this->data);
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