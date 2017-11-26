<?php 
    
if ( ! defined('BASEPATH')) 
exit('No direct script access allowed'); 

class Admin_User extends Base_Model 
{ 
    public function __construct() 
    { 	
        parent::__construct(); 
        $this->table = 'admin';
    } 



    public function getUserByUsername($username)
    {
        $this->db->select('*, user.id as user_id');
        $this->db->from('user');
        $this->db->join('user_type', 'user.type = user_type.id','inner');
        $this->db->where_in('user.username',$username);
        $query = $this->db->get();

        return ($query->result());
    }


    public function getSocial($id)
    {
        $this->db->select('*');
        $this->db->from('user_social');
        $this->db->join('social_network', 'user_social.social_id = social_network.id','inner');
        $this->db->where_in('user_social.user_id',$id);
        $query = $this->db->get();

        return ($query->result());
    }


     public function getContacts($id)
    {
        $this->db->select('*');
        $this->db->from('user_contact');
        $this->db->join('contact_type', 'user_contact.contact_id = contact_type.id','inner');
        $this->db->where_in('user_contact.user_id',$id);
        $query = $this->db->get();

        return ($query->result());
    }

    public function getUsersByType($conditions = null, $types , $limit = 500000)
     {
        // $this->db->select('*');
        // $this->db->from('user');
        // $this->db->where_in('type',$types);
        // $query = $this->db->get();

        // return ($query->result());
        // printme($types);
        $this->db->select('*, user.id as user_id');
        $this->db->from('user');
        $this->db->join('user_type', 'user.type = user_type.id','inner');
        $this->db->where_in('user.type',$types);
        if($conditions != NULL) 
                $this->db->where($conditions);
        $this->db->order_by("user.creation_date", "desc");
        $this->db->limit($limit);
        $query = $this->db->get(null,null,$limit);

        return ($query->result());
    }

    public function insert($user)
    {   
        unset($user['verify']);
        
    	$random_key = uniqid();
    	$password = $this->hash_password($user['password'],$random_key);

    	$user['password']   = $password;
    	$user['random_key'] = $random_key;

    	$process = $this->Adminuser->put($user);

    	if($process == 1)
        {
    		return true;
        }
    	return false;

    }


    public function checkUsername($username)
    {
        $user = $this->get(array("username"=>$username));

        if(!empty($user))
            return $user;
        return false;
    }
    
    public function checkLogin($username,$password)
    {
    	$user = $this->get(array("username"=>$username));

    	if(!empty($user))
    	{
    		$user = $user[0];
    		$random_key = $user->random_key;
    		$checkPassword = $this->hash_password($password,$random_key);
    		if($checkPassword == $user->password) // Check if its an admin Account
    			return $user;
    	}

    	return false;

    }

    public function changePassword($user_id,$password,$random_key)
    {   
        $process = $this->Adminuser->update(array("password"=>$this->hash_password($password,$random_key)),array("user_id"=>$user_id));
        if($process == 1)
            return true;
        return false;
    }

    public function hash_password($password,$random_key)
    {
    	return md5($password.md5($random_key));
    }

    public function getUserProfilePicture($userID)
    {
        $this->db->select('*');
        $this->db->from('profile_picture');
        $this->db->where('user_id',$userID);
        $query = $this->db->get();

        return ($query->result());
    }

}

 ?>