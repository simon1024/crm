<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chart extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('chart_model');
    }

    public function index($slug){
        $file = '../application/views/pages/'.$page.'.php';
        if(!file_exists($file)){
            show_404();
        }
    }

    public function bddate(){
        $data = array('abtest'=>'Hello pqcc');
        $this->load->view('templates/header', $data);
        $this->load->view('chart/bddate', $data);
        $this->load->view('templates/footer', $data);
    }

    public function bdList(){
        //
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
