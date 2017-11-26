<?php 

if ( ! defined('BASEPATH')) 
    exit('No direct script access allowed'); 

class Base_Model extends CI_Model 
{ 
    public $table; 
    public function __construct() 
    { 
        parent::__construct(); 
        $this->table = get_Class($this); 
        $this->load->database(); 
    }

    
		public function save($data,$tablename="") 
		{ 
		    if($tablename=="") 
		    { 
		        $tablename = $this->table; 
		    } 
		    $op = 'update'; 
		    $keyExists = FALSE; 
		    $fields = $this->db->field_data($tablename); 

		    foreach ($fields as $field) 
		    { 
		        if($field->primary_key==1) 
		        { 
		            $keyExists = TRUE;
		            if(isset($data[$field->name])) 
		            { 
		                $this->db->where($field->name, $data[$field->name]); 
		            } 
		            else 
		            { 
		                $op = 'insert'; 
		            } 
		        } 
		    } 
		    if($keyExists && $op=='update') 
		    { 
		        $this->db->set($data); 
		        $this->db->update($tablename); 
		        if($this->db->affected_rows()==1) 
		        { 
		            return $this->db->affected_rows(); 
		        } 
		    } 
		    $this->db->insert($tablename,$data); 
		    return $this->db->affected_rows(); 
		} 

		function get($conditions=NULL,$tablename="",$limit=null,$offset=0,$order=null) 
		{     
		    if($tablename=="") 
		    { 
		        $tablename = $this->table; 
		    } 
		    if($conditions != NULL) 
		        $this->db->where($conditions);

	      if($order != NULL) 
	         $this->db->order_by($order['by'],$order['direction']);  

		    $query = $this->db->get($tablename,$limit,$offset=0); 
		    return $query->result(); 
		} 

		function get_where_in($attr,$values,$tablename="",$limit=null,$offset=0,$order=null)
		{	


			if($tablename=="") 
		    { 
		        $tablename = $this->table; 
		    } 
		    
		    $this->db->where_in($attr,$values);


		    $query = $this->db->get($tablename,$limit,$offset=0);
		    return $query->result();
		}

		function getCount($conditions=NULL,$tablename="",$limit=null,$offset=0,$order=null)
		{	

			$this->db->select('count(id) as count');

			if($tablename=="") 
		    { 
		        $tablename = $this->table; 
		    } 
		    if($conditions != NULL) 
		        $this->db->where($conditions);

		    $query = $this->db->get($tablename,$limit,$offset=0); 
		    return $query->row()->count; 
		}
		function put($data,$tablename="") 
		{ 
		    if($tablename=="") 
		        $tablename = $this->table; 
		    $this->db->insert($tablename,$data); 
		    return $this->db->affected_rows(); 
		} 

		function update($data,$conditions,$tablename="") 
		{ 
		    if($tablename=="") 
		        $tablename = $this->table; $this->db->where($conditions); 
		    $this->db->update($tablename,$data); 
		    return $this->db->affected_rows(); 
		} 

		function delete($conditions,$tablename="") 
		{ 
		    if($tablename=="") 
		        $tablename = $this->table; 
		    $this->db->where($conditions); 
		    $this->db->delete($tablename); 
		    return $this->db->affected_rows(); 
		} 
}


 ?>