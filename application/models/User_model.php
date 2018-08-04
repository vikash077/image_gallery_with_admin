<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    function userListing()
    {
        $this->db->select('id,user_name,Name, access');
        $this->db->from('users');
        $this->db->where('isDeleted', 0);
        $this->db->where('access !=', 'Admin');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    
    
    
}

  