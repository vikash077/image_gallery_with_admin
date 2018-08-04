<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->helper(['form', 'url','cias']);
        $this->load->library(array('form_validation', 'session', 'user_agent'));
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }
    
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            redirect('/');
        }
    }
    
    
    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
        $post = $this->input->post();
       
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'User Name', 'required|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            
            $result = $this->login_model->loginMe($email, $password);
            
            if(count($result) > 0)
            {
                foreach ($result as $res)
                {
                    $sessionArray = array('userId'=>$res->id,  
                                          'user_name'=>$res->user_name,
                                          'access'=>$res->access,
                                          'roleText'=>$res->access,
                                          'name'=>$res->Name,
                                          'isLoggedIn' => TRUE
                                    );
                                    
                    $this->session->set_userdata($sessionArray);
                    if($sessionArray['access'] == 'Admin'){
                        redirect('/admin');
                    }else{
                        redirect('/');
                    }
                }
            }
            else
            {
                $this->session->set_flashdata('error', 'Email or password mismatch');
                
                redirect('/login');
            }
        }
    }

    /**
     * This function used to load forgot password view
     */
    function forgotPassword()
    {
        $this->load->view('forgotPassword');
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email|xss_clean');
                
        if($this->form_validation->run() == FALSE)
        {
            $this->forgetPasswordUser();
        }
        else 
        {
            $email = $this->input->post('login_email');
            
            if($this->user_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);
                
                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['created_dtm'] = date('Y-m-d H:i:s');
                $data['agent'] = $this->getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();
                
                $save = $this->user_model->resetPasswordUser($data);                
                
                if($save)
                {
                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $config['charset'] = 'UTF-8';
                    $config['wordwrap'] = TRUE;
                    $config['mailtype'] = 'html';
                    
                    $this->load->library('email', $config);
                    
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $data1['info'] = $this->user_model->getCustomerInfoByEmail($email);
                    
                    $this->email->from(ADMIN_EMAIL_ID, WEBSITE);
                    $this->email->to($email);
                    $this->email->subject(RESET_PASSWORD_EMAIL_SUBJECT);
                    $this->email->message($this->load->view('email', $data1, TRUE));
                    
                    if ($this->email->send())
                    {
                        $status = 'send';
                    }
                    else
                    {
                        $status = 'notsend';
                    }
                }
                else
                {
                    $status = 'unable';
                }
            }
            else
            {
                $status = 'invalid';
            }
            
            echo json_encode(array('status'=>$status));
        }
    }

    // This function used to reset the password 
    function resetPasswordConfirmUser()
    {
       
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($this->uri->segment(3));
        $activation_id = $this->uri->segment(2);
        
        // Check activation id in database
        $is_correct = $this->user_model->checkActivationDetails($email, $activation_id);
        
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct == 1)
        {
            $this->load->view('includes/header');
            $this->load->view('new_password', $data);
            $this->load->view('includes/footer');
        }
        else
        {
            redirect('user');
        }
    }
    
    public function logout(){
        $this->session->sess_destroy();
        redirect('/login');
    }

}

?>