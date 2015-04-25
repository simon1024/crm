<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dict extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('dict_model');
    }

    public function add(){
        //$exits = $this->dict_model->getDictList('');
        $table = $this->input->post('table');
        $name  = $this->input->post('name');
        $ret = $this->dict_model->addDict($table, array('name'=>$name));
        var_dump($ret);
    }


    public function getList(){
        //$exits = $this->dict_model->getDictList('');
        $table = $this->input->post('table');
        $ret = $this->dict_model->getDictList($table);
        var_dump($ret);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
