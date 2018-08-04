<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('form_validation', 'session', 'user_agent'));
        $this->load->helper(['form', 'url','image']);
        
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE){
            redirect('login');
        }
    }

	public function index()
	{
            $user_data = $this->session->userdata();
            
	    $this->load->view('app',['user_data'=>$user_data]);
	}
        
        public function search() {
            $search = $this->input->get('search');
            if(!empty($search)){
                $sql = "SELECT * FROM files where 1=1 AND (find_in_set('$search',tags) OR file like '%$search%')";

                $search_data = $this->db->query($sql)->result_array();
                $user_data = $this->session->userdata();

                $this->load->view('app',['search'=>$search_data,'search_txt' => $search,'user_data'=>$user_data]);
            }else{
                redirect('/');
            }
        }
        
        public function get_file() {
            $size = array_filter(explode('X', $this->input->get('size')));
            get_file(BASEPATH . '../gallery/'.$this->input->get('file'),$size);
        }
        
        public function get_thumbnail() {
            $size = array_filter(explode('X', $this->input->get('size')));
            resizeImage(BASEPATH . '../gallery/'.$this->input->get('file'), $size[0], $size[1], 2, 0, FALSE, $cropZoom=True);
        }
}