<?php 
    
if ( ! defined('BASEPATH')) 
exit('No direct script access allowed'); 

class Instagram_User extends Base_Model 
{ 

    public function __construct() 
    { 	
        parent::__construct(); 
        $this->table = 'instagram_user';
    } 

}

 ?>