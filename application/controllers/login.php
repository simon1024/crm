<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    private $md5_prefix = 'psd_';

    public function __construct(){
        parent::__construct();
        $this->load->model('employee_model');
        //$this->load->model('dict_model');
    }

    public function index(){
        $this->load->view('login/index');
    }

    public function resetPasswd(){
        $this->load->view('login/resetPasswd');
    }
 
    private function sendMail($toEmail, $subject, $content){
        $fromEmail = 'crm@zhlbt.com';
        $fromName = '公司管理系统';
        $this->load->library('email');
        $this->email->from($fromEmail, $fromName);
        $this->email->to($toEmail); 
        $this->email->subject($fromName);
        $this->email->message($content);  
        return $this->email->send();
    }

    private function random_password( $length = 8 ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }

    public function generatePwd(){
        $array = array('name' => 'username', );
        $model = $this->formDataToModel($array, 'post');
        $password = $this->random_password(8);
        /* $password = 'abcdefg'; */
        $email = $this->employee_model->getMailByUserName($model['username']);
        if ($email == "wrong"){
            $result = array("status"=>"no", "msg"=>"wrong user name");
            echo json_encode($result);
            exit;
        }
        $tmpTime = time();
        $pwd = $this->md5_prefix . $password;
        $pwd = md5($pwd);
        $tmp = array('tmpPwd' => $pwd, 'tmpTime' => $tmpTime );
        $this->employee_model->updateByUserName($model['username'], $tmp);
        $subject = "temporary password";
        $content = "The temporary passord is: " . $password . ". Please login in 5 minutes and reset your password.";
        $ret = $this->sendMail($email, $subject, $content);

        if ($ret) {
            $result = array("status"=>"ok", "msg"=>"sent success");
            echo json_encode($result);
        }else {
            $result = array("status"=>"no", "msg"=>"sent failed");
            echo json_encode($result);
        }

        exit;
    }

    public function check(){
        $userName = $this->input->post('username');
        $pwd = $this->input->post('password');
        $result = $this->employee_model->login($userName, $pwd);
        if($result['status'] == 'ok'){
            $this->setUserSession($result['user']);
        }
        unset($result['user']);
        echo json_encode($result);
    }


    public function logout(){
        $this->session->unset_userdata('user');
        redirect('/login/login');
        exit;
    }

   
    /**
     * @Desc: 检查用户名是否存在.
     * @parameter: username.
     **/
    public function exits(){/*{{{*/
        $userName = $this->input->get('username');
        $exits = $this->employee_model->checkUserNameExists($userName);
        var_dump($exits);
        exit;
    }/*}}}*/

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
