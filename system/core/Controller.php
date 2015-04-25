<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;
		
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();

        // @changed by pqcc.
        $this->load->library('session');
        $this->load->helper('url');
        $currentUri = "/" . $this->router->fetch_class() . "/" . $this->router->fetch_method();
        $sessionUser = $this->getSessionUserInfo();
        $this->checkPermission($currentUri, $sessionUser);
		log_message('debug', "Controller Class Initialized");
	}

	public function checkPermission($currentUri, $sessionUser){
        // check if uri not /login && sessionUser is empty, redirect to /login
        if(  !($sessionUser) && ($this->router->fetch_class() != 'login') ){
            redirect('/login/login');
            exit;
        }elseif( 
            $sessionUser 
            && ($this->router->fetch_class() == 'login')
            && ($this->router->fetch_method() == 'index')
        ){
            redirect('/timesheet/index');
            exit;
        }
        $success = $this->checkPermissionByConfig($currentUri, $sessionUser);
        if(!$success){
            $array = array('status'=>'no', 'msg'=>'权限不足');
            echo json_encode($array);
            exit;
        }
    }

	public function checkPermissionByConfig($uri, $user){
        $this->config->load('permission');
        $permission = $this->config->item('permission');
        $rolePermission = $permission['role'];
        $userRole = $user['role'];
        $success = true;

        // 超级管理员.
        if($userRole == 1){
            return true;
        }
        // if need ,check role permission
        $uri = strtolower($uri);
        if(array_key_exists($uri, $rolePermission)){
            $validRole = $rolePermission[$uri];
            $validRole = explode(',', $validRole);
            // check failure.
            if(!in_array($userRole, $validRole)){
                $success = false;
            }
        }
        return $success;
    }

	public static function &get_instance()
	{
		return self::$instance;
	}

    /**
     * @pqcc extend: transform form data to entity.
     **/
    public function formDataToModel($array, $method){
        $data = array();
        foreach($array as $key=>$value){
            if(is_numeric($key)){
                $formKey = $value;
                $modelKey = $value;
            }else{
                $formKey = $key;
                $modelKey = $value;
            }
            $formValue = $this->input->$method($formKey);
            $data[$value] = $formValue;
        }
        return $data;
    }

    /**
     * @pqcc extend: get REQUEST_METHOD.
     **/
    public function getMethod(){
        return $this->input->server('REQUEST_METHOD');
    }

    public function setUserSession($data){
        unset($data['pwd']);
        $array = array("user"=>$data);
        $this->session->set_userdata($array);
    }

    public function getSessionUserInfo(){
        $user = $this->session->userdata('user');
        return $user;
    }

    public function getSessionUid(){
        $user = $this->getSessionUserInfo();
        return $user['id'];
    }

    public static function getRoleId(){
        $user = $this->getSessionUserInfo();
        return $user['role'];
    }







    public function getBasePaginationConfig(){

        //$config['num_links'] = 2;
        $config['use_page_numbers'] = TRUE;
        $config['uri_segment'] = 3; 
        $config['reuse_query_string'] = TRUE;

        // set current style.
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        // prev
        $config['prev_link'] = '上一页';
        $config['prev_tag_open'] = "<li class='prev'>";
        $config['prev_tag_close'] = "</li>";

        // next
        $config['next_link'] = '下一页';
        $config['next_tag_open'] = "<li class='next'>";
        $config['next_tag_close'] = "</li>";

        // first
        $config['first_link'] = '《';
        $config['first_tag_open'] = "<li>";
        $config['first_tag_close'] = "</li>";

        // last
        $config['last_link'] = ' 》';
        $config['last_tag_open'] = "<li>";
        $config['last_tag_close'] = "</li>";

        // digit 
        $config['num_tag_link'] = '下一页';
        $config['num_tag_open'] = "<li>";
        $config['num_tag_close'] = "</li>";


        return $config;

    }





}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */
