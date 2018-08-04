<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
    
    /**
     * This function used to check the login credentials of the user
     * @param string $email : This is email of the user
     * @param string $password : This is encrypted password of the user
     */
    function loginMe($email, $password)
    {
        //$this->db->select('BaseTbl.userId, BaseTbl.password, BaseTbl.name, BaseTbl.role_Id, Roles.role');
        $this->db->select('users.id,users.user_name, users.Name, users.access,users.password');
        $this->db->from('users');
        $this->db->where('users.user_name', $email);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        $user = $query->result();
        if(!empty($user)){
           if(verifyHashedPassword($password, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
}

?>
