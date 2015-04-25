<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stats extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('stats_model');
    }

    public function view($slug){
        $this->load->view('templates/header', $data);
        $this->load->view('stats/view', $data);
        $this->load->view('templates/footer');
    }


    public function query(){
        //$pointers = 'cookie_uv,cookie_pv,cookie_newUV,cookie_newActUV,cookie_actUV';
        $date   = $this->input->post('date');
        $endDate = $this->input->post('end_date');
        $date   = date('Ymd', strtotime($date));
        $endDate    = date('Ymd', strtotime($endDate));
        // check endTime.
        $diffTime = strtotime($endDate) - strtotime($date);
        if($date>$endDate || $diffTime>86400*60){
            $array = array('status'=>'no', 'message'=>'日期选择错误，最多选择60天数据.');
            echo json_encode($array); 
            exit;
        }
        // validate.
        /**
        $nowDate = date('Ymd');
        if($date>=$nowDate || date('Ymd', strtotime('-60 day'))>$date){
            $array = array('status'=>'no', 'message'=>'日期不在允许范围之内，日期格式 20130604');
            echo json_encode($array); 
            exit;
        }
        **/
        //exit;
        //echo $nowDate;
        //exit;
        $hosts  = substr($this->input->post('hosts'), 0, -1);
        $pointers = substr($this->input->post('pointers'), 0, -1);
        $filters  = $this->input->post('filters');
        $filters = explode(',', $filters);
        $filtersStr = "event_day=$date|$endDate,globalhao123_host=$hosts";
        //
        unset($filters['hosts']);
        foreach($filters as $filter){
            if(empty($filter))
                continue;
            list($k, $v) = explode('=', $filter);
            if("" != trim($v)){
                $filtersStr .= ",$k=$v";
            }
        }
        $result = $this->stats_model->query($pointers, $filtersStr);
        echo json_encode($result);
        exit;
        /**
        $data['title'] = 'Query Platform';
        $this->load->view('templates/header', $data);
        $this->load->view('stats/query', $data);
        $this->load->view('templates/footer', $data);
        **/
    }

    public function result(){
        $data = $this->stats_model->result();
        echo json_encode($data);
        exit;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
