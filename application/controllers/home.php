<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

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

		// printme($this->data);exit();
		$this->load->view('home',$this->data);
	}


	public function lists()
	{
		$this->data['lists'] = $this->User_List->get(array('admin_id'=>$this->data['admin'][0]->id));
		// printme($this->data);
		// exit();
		$this->load->view('lists',$this->data);
	}

	public function list($list)
	{
		$this->data['list'] = $this->User_List->get(array('admin_id'=>$this->data['admin'][0]->id,'id'=>$list));



		$this->data['actions'] = $this->User_List->getListActions($this->data['admin'][0]->id,$list);

		$this->data['users'] = explode(',', $this->data['list'][0]->users);
		unset($this->data['users'][count($this->data['users'])-1]);
		
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
		$this->load->view('list',$this->data);
	
	}


	public function exportusers()
	{	

		$this->data['previous_url'] = $_GET['current'];
		$this->data['data_source'] = $_GET['type'];


		$ids = $_GET['ids'];
		$type = $_GET['type'];


		$this->data['admin_lists'] = $this->User_List->get(array('admin_id'=>$this->data['admin'][0]->id));
		if($type == 'Instagram')
		{
			$ids = explode(',', $ids);
			unset($ids[count($ids)-1]);
			$this->data['users'] =  $this->Instagram_User->get_where_in('username',$ids);
		}

		if(isset($_POST['file_name']))
		{
			exportUsers($this->data['users'],$_POST['file_name']);
		}

		// printme($_GET);
		// exit();
		$this->load->view('exportusers',$this->data);
	}

	public function adduserstolist()
	{

		$this->data['previous_url'] = $_GET['current'];
		$this->data['data_source'] = $_GET['type'];

		if(isset($_POST['list_id']))
		{

			if($_POST['list_id'] == 0)
			{
				// NEW LIST
				$input = array();
				$input['admin_id'] = $this->data['admin'][0]->id;
				$input['name'] = $_POST['list-name'];
				$input['users'] = $_POST['list-users'];
				$input['source'] = $_GET['type'];
				//Get User Count
				$count = explode(',', $_POST['list-users']);
				$input['count'] = count($count);

				$save = $this->User_List->put($input);
				$this->data['success'] = ' ('.$input['name'].') Created Successfully';
				$this->data['post'] = $_POST;
			}
			else
			{
				// UPDATE LIST
				$old_list = $this->User_List->get(array('id'=>$_POST['list_id']));

				$new_users = explode(',', $_POST['list-users']);
				$old_users = $old_list[0]->users;

				$update_users = "";
				foreach ($new_users as $username) {
					if (strpos($old_users,$username) === false ) {
						    $update_users .= $username.",";
						}
				}

				$update_users = $old_users.','.$update_users;

				$count = explode(',', $update_users);
				unset($count[count($count)-1]);
				$input = array();
				$input['users'] = $update_users;
				$input['count'] = count($count);


				$save = $this->User_List->update($input,array('id'=>$old_list[0]->id));
				$this->data['success'] = ' ('.$old_list[0]->name.') Updated Successfully';
				$_POST['list-name'] = $old_list[0]->name;	
			$this->data['post'] = $_POST;
				
			}

		}

		$ids = $_GET['ids'];
		$type = $_GET['type'];


		$this->data['admin_lists'] = $this->User_List->get(array('admin_id'=>$this->data['admin'][0]->id));
		if($type == 'Instagram')
		{
			$ids = explode(',', $ids);

			unset($ids[count($ids)-1]);
			$this->data['users'] =  $this->Instagram_User->get_where_in('id',$ids);
		}

		

		$this->load->view('adduserstolist',$this->data);
	}


	public function checklistname()
	{
		$conditions = array();
		$conditions['admin_id'] = $_POST['admin'];
		$conditions['name'] = $_POST['list_name'];

		$check = $this->User_List->get($conditions);
		if(empty($check))
			echo  'true';
		else
			echo 'false';
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



	public function fix()
	{
		$users = $this->Instagram_User->get(array('feed'=>'0'),"",10000,"",array('by'=>'id','direction'=>'desc'));

		foreach ($users as $user) {
			$username = $user->username;

			// printme($user);
			$instaResult= file_get_contents('https://www.instagram.com/'.$username.'/media/');
			$insta = json_decode($instaResult);
			$total_locations = array();

			foreach ($insta->items as $post) {

				$input = array();
				$input['user_id'] = $user->id;
				$input['code'] = $post->code;
				$input['image_standard_url'] = $post->images->standard_resolution->url;
				$input['image_thumbnail_url'] = $post->images->thumbnail->url;
				$input['image_low_url'] = $post->images->low_resolution->url;
				$input['type'] = $post->type;
				$input['instagram_post_id'] = $post->id;
				$input['caption'] = utf8_encode($post->caption->text);
				$input['created_time_instagram'] = $post->created_time;
				$input['likes'] = $post->likes->count;
				$input['location'] = (isset($post->location->name))? $post->location->name : '';
				$this->Instagram_Post->put($input);
				$post_id = $this->db->insert_id();

				if(isset($post->location->name))
				{
					$input['location'] = strtolower(utf8_encode($post->location->name));
					$check = $this->Instagram_Location->get(array('text'=>$input['location']));
					$location_id = 0;
					if(empty($check))
					{	
						$locationCoords = getCoordinates($input['location']);
						$CountryCity    = getLocationByCoords($locationCoords[0],$locationCoords[1]);
						$location = array();
						$location['text'] = $input['location'];
						$location['count'] = 1;
						$location['lat'] = $locationCoords[0];
						$location['lng'] = $locationCoords[1];
						$location['country'] = $CountryCity['country'];
						$location['city'] = $CountryCity['city'];
						$this->Instagram_Location->put($location);
						$location_id = $this->db->insert_id();
					}
					else
					{
						$count = $check[0]->count;
						$count = $count + 1;
						$id = $check[0]->id;
						$this->Instagram_Location->update(array('count'=>$count),array('id'=>$id));
						$location_id = $id;
					}

					$location_user = array();
					$location_user['user_id'] = $user->id;
					$location_user['location_id'] = $location_id;
					$location_user['post_id'] = $post_id;
					$this->Instagram_Location_User->put($location_user);
				}
				else
				{
					$input['location'] = '';
				}

				

				$hashtags = get_hashtags(utf8_encode($post->caption->text), $str = 0);
				$post_hashtags = array_unique($hashtags,SORT_STRING);

				foreach ($post_hashtags as $x) {
					$check = $this->Instagram_Hashtag->get(array('text'=>$x));
					$hashtag_id = 0;
					if(empty($check))
					{
						// New Hashtag
						$hashtag = array();
						$hashtag['text'] = $x;
						$hashtag['count'] = 1;
						$this->Instagram_Hashtag->put($hashtag);
						$hashtag_id = $this->db->insert_id();
					}
					else
					{
						// Update Hashtag
						$count = $check[0]->count;
						$count = $count + 1;
						$id = $check[0]->id;
						$this->Instagram_Hashtag->update(array('count'=>$count),array('id'=>$id));
						$hashtag_id = $id;
					}

						$hashtag_user = array();
						$hashtag_user['user_id'] = $user->id;
						$hashtag_user['hashtag_id'] = $hashtag_id;
						$hashtag_user['post_id'] = $post_id;
						$this->Instagram_Hashtag_User->put($hashtag_user);
				}

				$comments = $post->comments->data;
				if(!empty($comments))
				{	
					foreach ($comments as $comment) {
						$comment_input = array();
						$comment_input['post_id'] = $post_id;
						$comment_input['from_id'] = $comment->from->id;
						$comment_input['from_username'] = $comment->from->username;
						$comment_input['text'] = utf8_encode($comment->text);
						$this->Instagram_Comment->put($comment_input);
					}
					
					$this->Instagram_Post->update(array('comments'=>$post->comments->count),array('id'=>$post_id));
				}

			}

			$this->Instagram_User->update(array('feed'=>'1',),array('id'=>$user->id));
			
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */