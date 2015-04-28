<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finance extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('project_model');
        $this->load->model('timesheet_model');
        $this->load->model('dict_model');
        $this->load->model('employee_model');
    }

    public function report() {
        $data = array();
        $data['projectList'] = $this->project_model->getProjectListForFinance();
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('finance/report', $data);
        $this->load->view('templates/footer');
    }

    public function exportEmployeeReport() {
        $startTime = ($this->uri->segment(3));
        $endTime = ($this->uri->segment(4));
        $pjNo = ($this->uri->segment(5));
        $pid = 0;
        if($pjNo) {
            $pid = $this->project_model->getPidByPno($pjNo); 
        }

        if(empty($startTime)){
            $startTime = '';
        }else{
            $startTime = date('Y-m-d H:i:s', strtotime($startTime));
        }
        if(empty($endTime)){
            $endTime = '';
        }else{
            $endTime = date('Y-m-d H:i:s', strtotime($endTime));
        }

        $filters = array(
                        'start'=>$startTime,
                        'end'=>$endTime,
                        'pid'=>$pid,
                    );

        $timeSheetList = $this->timesheet_model->exportEmployeeTimeSheet4Finance($filters);

        /* $timeSheetList = iconv('utf-8', 'gbk', $timeSheetList); */

        header("Content-Type: application/vnd.ms-excel; charset=gbk");

        $this->load->helper('download_helper');
        force_download('timeCostOfEachStaffForEachProject.csv', $timeSheetList);
    }

    public function exportProjectReport() {
        $startTime = ($this->uri->segment(3));
        $endTime = ($this->uri->segment(4));

        if(empty($startTime)){
            $startTime = '';
        }else{
            $startTime = date('Y-m-d H:i:s', strtotime($startTime));
        }
        if(empty($endTime)){
            $endTime = '';
        }else{
            $endTime = date('Y-m-d H:i:s', strtotime($endTime));
        }

        $filters = array(
                        'start'=>$startTime,
                        'end'=>$endTime,
                        'pid'=>0,
                    );

        $timeSheetList = $this->timesheet_model->exportProjectTimeSheet4Finance($filters);
        /* $timeSheetList = iconv('utf-8', 'gbk', $timeSheetList); */
        header("Content-Type: application/vnd.ms-excel; charset=gbk");
        $this->load->helper('download_helper');
        force_download('timeCostOfEachProject.csv', $timeSheetList);
    }

    public function exportOneProjectReport() {
        $pjNo = ($this->uri->segment(3));
        $startTime = ($this->uri->segment(4));
        $endTime = ($this->uri->segment(5));
        $timeRange = $this->timesheet_model->getTimeRangeOfProjectForFinance($pjNo);
        $pid = 0;
        if($pjNo) {
            $pid = $this->project_model->getPidByPno($pjNo); 
        }

        if(empty($startTime)){
            $startTime = $timeRange['startTime'];
            if ($startTime == '0000-00-00 00:00:00' and $timeRange['addTime'] != '0000-00-00 00:00:00') {
                $startTime = $timeRange['addTime'];
            }

            if ($startTime == '0000-00-00 00:00:00') {
                $startTime = date('Y-m-01 00:00:00', strtotime('-1 year'));;
            }
        }else{
            $startTime = date('Y-m-d H:i:s', strtotime($startTime));
        }
        if(empty($endTime)){
            $endTime = $timeRange['endTime'];
            if ($endTime == '0000-00-00 00:00:00') {
                $endTime = date('Y-m-d H:00:00');
            }
        }else{
            $endTime = date('Y-m-d H:i:s', strtotime($endTime));
        }

        $filters = array(
                        'start'=>$startTime,
                        'end'=>$endTime,
                        'pid'=>$pid,
                    );

        $timeSheetList = $this->timesheet_model->exportEmployeeTimeSheet4Finance($filters);

        /* $timeSheetList = iconv('utf-8', 'gbk', $timeSheetList); */

        header("Content-Type: application/vnd.ms-excel; charset=gbk");

        $this->load->helper('download_helper');
        force_download('timeCostOfOneProject.csv', $timeSheetList);
    }
}
