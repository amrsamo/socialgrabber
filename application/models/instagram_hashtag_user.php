<?php 
    
if ( ! defined('BASEPATH')) 
exit('No direct script access allowed'); 

class Instagram_Hashtag_User extends Base_Model 
{ 

    public function __construct() 
    { 	
        parent::__construct(); 
        $this->table = 'instagram_hashtag_user';
    } 


    //GET HASHTAGS RELATED TO ONE USER
    public function getUserHashtags($user_id)
    {	
    	$this->db->distinct();
    	$this->db->select('text');
        $this->db->from('instagram_hashtag_user');
        $this->db->join('instagram_hashtag', 'instagram_hashtag_user.hashtag_id = instagram_hashtag.id','inner');
        $this->db->where('instagram_hashtag_user.user_id',$user_id);
        $query = $this->db->get();

        return ($query->result());
    }

    //GET USERS RELATED TO HASHTAGS
    public function getHashtagsUsers($hashtag_id)
    {   
        $this->db->distinct();
        $this->db->select('user_id,username,followers');
        $this->db->from('instagram_hashtag_user');
        $this->db->join('instagram_user', 'instagram_hashtag_user.user_id = instagram_user.id','inner');
        $this->db->where('instagram_hashtag_user.hashtag_id',$hashtag_id);
        $this->db->order_by('user_id','desc');
        $query = $this->db->get();

        return ($query->result());
    }

}

 ?>