<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
    
    function __construct() {
        parent::__construct(); 
        $this->load->model('usermodel');
        $this->load->library('form_validation');
        $this->load->helper('file');
    }
    public function index(){
        $data = array();
        
        // Get messages from the session
        if($this->session->userdata('success_msg')){
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if($this->session->userdata('error_msg')){
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');
        }
        
        // Load the list page view
        $this->load->view('register', $data);
    }
//435B5F980264A967A43FDEF59C1EDFBBA4E9//smtp.elasticemail.com//2525
    public function register()
    {
        if(isset($_POST['register']))
        {
            $password = $this->input->post('password'); 
            $email = $this->input->post('email');
            $fullname = $this->input->post('full_name');  
            if($password != '' && $email !='' & $fullname !='') {
               
               $queryResult = $this->usermodel->registerUser();
                 if($queryResult != Null )
                {
                    $this->session->set_userdata('full_name',$queryResult->full_name);
                    $this->session->set_userdata('user_id',$queryResult->user_id);
                    redirect('register/dashboard');
                }
                else
                {
                    redirect('login');
                }
            } else {
                $this->session->set_userdata('error_msg', 'PLease ENter Valid Details');
                
            }
        }
    }
    public function dashboard(){
        $data = array();
        
        // Get messages from the session
        if($this->session->userdata('success_msg')){
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if($this->session->userdata('error_msg')){
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');
        }
        
        // Load the list page view
        $this->load->view('welcome', $data);
    }
    public function uploadusers(){
        $data = array();
        $memData = array();
        define('UPLOAD_DIR', 'assets/images/uploads');
        //define('UPLOAD_DIR', 'upload');
        define('UPLOAD_MAX_FILE_SIZE', 10485760); // 10MB.
        //@changed_2018-02-17_14.28
        if(isset($_POST['add']))
        {
            if (!is_dir(UPLOAD_DIR)) {
                mkdir(UPLOAD_DIR, 0777, true);
            }
            $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
            if($this->form_validation->run() == true){
                $uploadedFileName = basename($_FILES['file']['name']);
                $uploadedFilePath = rtrim(UPLOAD_DIR, '/') . '/' . $uploadedFileName;
                $insertCount = $updateCount = $rowCount = $notAddCount = 0;
                if ($_FILES['file']['size'] <= UPLOAD_MAX_FILE_SIZE) {
                    $uploadedFileTempName = $_FILES['file']['tmp_name'];
                    if(is_uploaded_file($_FILES['file']['tmp_name'])){
                            // Load CSV reader library
                            $this->load->library('CSVReader');
                            // Parse data from CSV file
                            $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                            if(!empty($csvData)){
                                foreach($csvData as $row){ $rowCount++;
                                    $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
                                    $password = substr(str_shuffle($data), 0, 7);
                                    // Prepare data for DB insertion
                                    $memData = array(
                                        'full_name' => $row['FullName'],
                                        'email' => $row['Email'],
                                        'password' => md5($password),
                                        'is_admin' =>0,
                                        'created_by'=>$this->session->userdata('user_id')
                                    );
                                    
                                    // Check whether email already exists in the database
                                    $con = array(
                                        'where' => array(
                                            'email' => $row['Email']
                                        ),
                                        'returnType' => 'count'
                                    );
                                    $prevCount = $this->usermodel->getRows($con,'my_users');
                                    
                                    if($prevCount > 0){
                                        // Update member data
                                        $condition = array('email' => $row['Email']);
                                        $update = $this->usermodel->update($memData, $condition);
                                        
                                        if($update){
                                            $updateCount++;
                                        }
                                    }else{
                                        // Insert member data
                                        $insert = $this->usermodel->insert($memData);
                                        
                                        if($insert){
                                            $insertCount++;
                                            $result = $this->send_email($row['Email'],$password,$row['FullName']);
                                        }
                                    }

                                }
                                // Status message with imported data count
                                $notAddCount = ($rowCount - ($insertCount + $updateCount));
                                $successMsg = 'Members imported successfully. Total Rows ('.$rowCount.') | Inserted ('.$insertCount.') | Updated ('.$updateCount.') | Not Inserted ('.$notAddCount.')';
                                $this->session->set_userdata('success_msg', $successMsg);
                            }  
                    }else{
                        $this->session->set_userdata('error_msg', 'Error on file upload, please try again.');
                    }
                }else{
                    $this->session->set_userdata('error_msg', 'File is Too Large.'); 
                }
            }else{
                $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
            }
        }
        redirect('register/dashboard');
    }
    private function send_email($tomail,$password,$fullname){
        $url = 'https://api.elasticemail.com/v2/email/send';
        $subject = 'Signup | Verification';	
       $body ="<p>Thanks for signing up!</p> <p>Your account has been created, you can login with the following credentials </p><br> Username: ".$fullname." <br>Password: ".$password."<br>";	
                
        try{
                $post = array('from' => 'xxxxxx@gmail.com',
                'fromName' => 'Testing',
                'apikey' => 'xxxxxxx',
                'subject' => $subject,
                'to' => $tomail,
                'bodyHtml' => '<h1>Html Body</h1>',
                'bodyText' => $body,
                'isTransactional' => false);
                
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $post,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER => false,
                    CURLOPT_SSL_VERIFYPEER => false
                ));
                
                $result=curl_exec ($ch);
                curl_close ($ch);
                echo $result;

                return $result;	
        }
        catch(Exception $ex){
            echo $ex->getMessage();
        }
    }
    public function file_check($str){
        $allowed_mime_types = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
            $mime = get_mime_by_extension($_FILES['file']['name']);
            $fileAr = explode('.', $_FILES['file']['name']);
            $ext = end($fileAr);
            if(($ext == 'csv') && in_array($mime, $allowed_mime_types)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only CSV file to upload.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please select a CSV file to upload.');
            return false;
        }
    }
    
    public function logout()
    {
        $this->session->unset_userdata('full_name');
        $this->session->unset_userdata('user_id');
        redirect('login');
    }
    
}

?>