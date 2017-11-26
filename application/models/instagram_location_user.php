<?php 
    
if ( ! defined('BASEPATH')) 
exit('No direct script access allowed'); 

class Instagram_Location_User extends Base_Model 
{ 

    public function __construct() 
    { 	
        parent::__construct(); 
        $this->table = 'instagram_location_user';
    } 


    public function getUserCountryCity($user_id)
    {
    	$this->db->distinct();
    	$this->db->select('country,city');
        $this->db->from('instagram_location_user');
        $this->db->join('instagram_location', 'instagram_location_user.location_id = instagram_location.id','inner');
        $this->db->where('instagram_location_user.user_id',$user_id);
        $query = $this->db->get();

        return ($query->row());
    }



    //GET USERS RELATED TO LOCATION
    public function getLocationUsers($location_id)
    {
        $this->db->distinct();
        $this->db->select('user_id,username,followers');
        $this->db->from('instagram_location_user');
        $this->db->join('instagram_user', 'instagram_location_user.user_id = instagram_user.id','inner');
        $this->db->where('instagram_location_user.location_id',$location_id);
        $this->db->order_by('user_id','desc');
        $query = $this->db->get();

        return ($query->result());
    }

}

 ?>