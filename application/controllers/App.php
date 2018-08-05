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
        
        public function getRequredSize($input_file,$size) {
            
            $file = realpath($input_file);
            $path_info = pathinfo($file);
            //return str_replace(GALLERY_PATH, GALLERY_CACHE_PATH, $path_info['dirname']) . DIRECTORY_SEPARATOR . $path_info['filename'] . $w . 'X' . $h . '.' . $path_info['extension'];
            $output_file = '/tmp/' . $path_info['filename'] .'-'.$size.'.' .$path_info['extension'];

            $cmd = "convert -resize {$size}%  $input_file $output_file";
            exec("convert $cmd");
            
            return $output_file;
        }
        
        public function download() {
            $filepath = BASEPATH . '../gallery/'.$this->input->get('file');
            $size = $this->input->get('size');
            if(!empty($size)){
               $filepath = $this->getRequredSize($filepath,$size);
            }
            
            if(file_exists($filepath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filepath));
                flush(); // Flush system output buffer
                readfile($filepath);
                exit;
            }
        }
}
