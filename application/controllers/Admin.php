<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Admin
 *
 * @author Vikash Kumar
 */
class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->database();
        $this->load->model('user_model');
        $this->load->library(array('form_validation', 'session', 'user_agent'));
        $this->load->helper(['utf8','form', 'url','image','cias']);
        
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE){
            redirect('login');
        }
    }

    public function index() {
        $files = $this->scanDir();
        $user_data = $this->session->userdata();
        $header = $this->load->view('/include/header',['user_data'=>$user_data],true);
        $footer = $this->load->view('/include/footer',[],true);
        $this->load->view('/include/head',[]);
        $this->load->view('/admin/index', 
                ['files' => $files,'user_data'=>$user_data,'header'=>$header,'footer'=>$footer]
                );
    }

    protected function get_dir_files($dir) {
        return glob($dir . "/*.{jpg,jpeg,png}", GLOB_BRACE);
    }

    protected function scan($dir) {
        foreach ($dir as $l) {
            $d = glob($l . DIRECTORY_SEPARATOR . "*", GLOB_ONLYDIR);
            $this->data[$l] = [];
            $this->scan($d);
            //$this->data[$l] = $this->get_dir_files($l);
        }
    }

    protected function scanDir() {

        $startpath = BASEPATH . '../gallery';
        //$regex_file_filter = '/(\.htaccess|\.txt|\.html|\.php)$/i';
        $regex_file_filter= '/(\.jpg|\.jpeg|\.png|\.tif|\.cdr)$/i';
        
        //$dir = glob($path,GLOB_ONLYDIR);

        $ritit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($startpath), RecursiveIteratorIterator::CHILD_FIRST);
        $r = array();
        foreach ($ritit as $splFileInfo) {
            
            $path = $splFileInfo->isDir() ?( !in_array($splFileInfo->getFilename(), ['.','..'])? [$splFileInfo->getFilename() => []]:[]) : (preg_match($regex_file_filter, $splFileInfo->getFilename())?[$splFileInfo->getFilename()]:[]);

            for ($depth = $ritit->getDepth() - 1; $depth >= 0; $depth--) {
                $file = $ritit->getSubIterator($depth)->current()->getFilename();
                //if(is_dir($file)){
                    $path = array($file => $path);
                //}
            }
            $r = array_merge_recursive($r, $path);
        }
        ksort($r);
        
        $tree = $this->treeData($r);
        
        return $tree;
        
    }
    
    protected function treeData($data) {
        
        
        //print_r($data);
        $result = [];
        $key=1;
        foreach($data as $k=>$d){
            if(is_array($d)){
                $result[] = [
                    'title'=>$k,
                    'isFolder'=> true,
                    'children'=> $this->treeData($d),
                    'key'=>'key'.$key
                    ];
            }else{
                $result[] = ['title'=>$d,'key'=>'key'.$key.".".$key];
            }
            $k++;
            
        }
        
        return $result;
    }
    
    public function get_img_details() {
        try{
            $file = BASEPATH . '../gallery/'.$this->input->get('file');
             $image = new Imagick($file);
             $exifArray = $image->identifyImage();
            echo json_encode($exifArray);
            die();
        }catch(Exception $e){
            echo json_encode(['error'=>'cant acces Details']);
            die();
        }
    }
    
    public function get_file() {
        $size = array_filter(explode('X', $this->input->get('size')));
        get_file(BASEPATH . '../gallery/'.$this->input->get('file'),$size);
    }
    
    public function get_img_tags() {
        $file = $this->input->get('file');
        $tags = $this->db->select('*')
                ->from('files')
                ->where(['file'=>$file])
                ->get()->result_array();
        
        echo json_encode($tags[0]);
        die;
    }
    
    public function saveTag() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('img', 'Image', 'required');
        $this->form_validation->set_rules('tags', 'tags', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
            die;
        }else{
            $this->db->trans_start();
              $this->db->delete('files',['file'=> $this->input->get('img')]);
              $this->db->insert('files',['file'=> $this->input->get('img'),
                  'tags'=>$this->input->get('tags'),
                  'title'=> $this->input->get('title')]);
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Some error has occurred!";
                die;
            } 
            else {
                $this->db->trans_commit();
                echo "Successfully Added!";
                die;
            }
        }
    }
    
    /* Users functions*/
    
    public function users()
   {
       $data['data']= $this->user_model->userListing();   
       $user_data = $this->session->userdata();
       $data['header'] = $this->load->view('/include/header',['user_data'=>$user_data],true);
       $data['footer'] = $this->load->view('/include/footer',[],true);
       $this->load->view('/include/head',[]);
       $this->load->view('users/list',$data);
   }
   
   public function create()
   {
      $this->load->view('includes/header');
      $this->load->view('products/create');
      $this->load->view('includes/footer');      
   }
   
   
   
   // This function used to create new password
    function createPasswordUser()
    {
        try{
            $this->load->library('form_validation');

            $this->form_validation->set_rules('name','Name','trim|required|max_length[20]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email');
            $this->form_validation->set_rules('access','Access','required|max_length[20]');
            $this->form_validation->set_rules('password','New Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','New Re-Password','trim|required|matches[password]|max_length[20]');

            if($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('errors', json_encode(array('errors' => validation_errors())));
                redirect("admin/users");
                return;
            }
            else
            {
                $password = $this->input->post('password');
                $cpassword = $this->input->post('cpassword');
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $access = $this->input->post('access');

                // Check activation id in database
                //$is_correct = $this->user_model->checkActivationDetails($email, $activation_id);
                $is_correct =  1;
                if(($is_correct == 1) && ($password == $cpassword))
                {
                    $password = getHashedPassword($password);
                    $data = [
                        'user_name'=>$email,
                        'Name'=>$name,
                        'access'=>$access,
                        'password'=>$password
                        ];

                    if($this->db->insert('users',$data)){
                        $this->session->set_flashdata('success', 'New User is added successfully');
                        redirect("admin/users");
                        return;
                    }
                }
                else
                {
                    $this->session->set_flashdata('error', 'confirm password do not match');
                    redirect("admin/users");
                    return;
                }
                $this->session->set_flashdata('error', 'Something went wrong!');
                redirect("admin/users");
                return;
            }
        }catch(PDOException $e){
            $this->session->set_flashdata('error', 'Something went wrong!');
            redirect("admin/users");
            return;
        }catch(Exception $e){
            $this->session->set_flashdata('error', 'Something went wrong!');
            redirect("admin/users");
            return;
        }
    }
   /**
    * Edit Data from this method.
    *
    * @return Response
   */
   public function edit($id)
   {
       $product = $this->db->get_where('products', array('id' => $id))->row();
       $this->load->view('includes/header');
       $this->load->view('products/edit',array('product'=>$product));
       $this->load->view('includes/footer');   
   }
   /**
    * Update Data from this method.
    *
    * @return Response
   */
   public function update($id)
   {
       $products=new ProductsModel;
       $products->update_product($id);
       redirect(base_url('products'));
   }
   /**
    * Delete Data from this method.
    *
    * @return Response
   */
   public function delete_user($id)
   {
       if($this->db->delete('users',['id'=> $id])){
           $this->session->set_flashdata('success', 'User Succesfully deleted');
           redirect("admin/users");
           return;
       }
       
        $this->session->set_flashdata('error', 'Something went wrong!');
        redirect("admin/users");
        return;
   }


}
