<?php 
    
if ( ! defined('BASEPATH')) 
exit('No direct script access allowed'); 

class User_List extends Base_Model 
{ 

    public function __construct() 
    { 	
        parent::__construct(); 
        $this->table = 'user_list';
    } 


    public function getListActions($user_id,$list_id)
    {
    	$this->db->select('*');
        $this->db->from('user_list_action');
        $this->db->where('user_id',$user_id);
        $this->db->where('list_id',$list_id);
        $query = $this->db->get();

        return ($query->result());
    }

    public function getCustomLists($admin_id)
    {
        $this->db->select('*');
        $this->db->from('user_list');
        $this->db->where('admin_id',$admin_id);
        $this->db->where_not_in('name',array('favorites','curated'));
        $query = $this->db->get();

        return ($query->result());
    }
}	

 ?>