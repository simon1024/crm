<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TimeSheet extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('project_model');
        $this->load->model('timesheet_model');
        $this->load->model('dict_model');
        $this->load->model('task_model');
        $this->load->model('employee_model');
    }


    public function listAll(){
        $this->listTimeSheetByType(1);
    }

    public function otList(){
        $this->listTimeSheetByType(2);
    }

    public function leaveList(){
        $this->listTimeSheetByType(3);
    }


    public function listTimeSheetByType($type){
        /**
        if($type == 2){
            $title = "加班工时列表";
        }elseif($type == 3){
            $title = "休假工时列表";
        }else{
            $title = "正常工时列表";
        }
        **/
        $title = "工时列表";
        $index = intval($this->uri->segment(3));
        $timeRange = $this->getTimeRangeKey($index);
        $user  = $this->getSessionUserInfo();
        $uid = $user['id'];
        $timeSheetList = $this->timesheet_model->getListByUidAndType($uid, $timeRange, $type);
        //echo json_encode($timeSheetList);
        //exit;
        // 按 uid 查询用户参与的项目 .
        $ohProjectList = $this->project_model->getOHProjectListByUid($user);
		$leaveProjectList = $this->project_model->getLeaveProjectListByUid($user);
        $ohTaskList = $this->task_model->getOHTaskByUser($user);
        $leaveTaskList = $this->task_model->getLeaveTaskByUser($user);
        $projectList = $this->project_model->getTimeSheetProjectListByUid($uid, 0, 100);
        $tasksList = $this->task_model->getTaskByPids($projectList);
        //echo json_encode($tasksList);
        //exit;
        // count allTypeHours.
        $days1_total = 0;
        $days2_total = 0;
        $days3_total = 0;
        $days4_total = 0;
        $days5_total = 0;
        $days6_total = 0;
        $days7_total = 0;
        $allTotal = 0;
        // normal
        $days1_normalTotal = 0;
        $days2_normalTotal = 0;
        $days3_normalTotal = 0;
        $days4_normalTotal = 0;
        $days5_normalTotal = 0;
        $days6_normalTotal = 0;
        $days7_normalTotal = 0;
        $normalTotal = 0;

        foreach($timeSheetList as $item){
            $days1_total  += $item['day1_hours'];
            $days2_total  += $item['day2_hours'];
            $days3_total  += $item['day3_hours'];
            $days4_total  += $item['day4_hours'];
            $days5_total  += $item['day5_hours'];
            $days6_total  += $item['day6_hours'];
            $days7_total  += $item['day7_hours'];
            $allTotal += $item['total_hours'];
            if($item['type'] != 2){
                $days1_normalTotal  += $item['day1_hours'];
                $days2_normalTotal  += $item['day2_hours'];
                $days3_normalTotal  += $item['day3_hours'];
                $days4_normalTotal  += $item['day4_hours'];
                $days5_normalTotal  += $item['day5_hours'];
                $days6_normalTotal  += $item['day6_hours'];
                $days7_normalTotal  += $item['day7_hours'];
                $normalTotal += $item['total_hours'];
            }
        }
        $data = array(
                    'timeSheetList' => $timeSheetList,
                    'projectList' => $projectList,
                    'ohProjectList' => $ohProjectList,
                    'leaveProjectList' => $leaveProjectList,
                    'ohTaskList' => $ohTaskList,
                    'leaveTaskList' => $leaveTaskList,
                    'taskList' => $tasksList,
                    'timeRange' => $timeRange,
                    'title' => $title,
                    'timeSheetType' => $type,
                    'days1_total' =>$days1_total,
                    'days2_total' =>$days2_total,
                    'days3_total' =>$days3_total,
                    'days4_total' =>$days4_total,
                    'days5_total' =>$days5_total,
                    'days6_total' =>$days6_total,
                    'days7_total' =>$days7_total,
                    'allTotal'    =>$allTotal,
                    'days1_normalTotal' => $days1_normalTotal,
                    'days2_normalTotal' => $days2_normalTotal,
                    'days3_normalTotal' => $days3_normalTotal,
                    'days4_normalTotal' => $days4_normalTotal,
                    'days5_normalTotal' => $days5_normalTotal,
                    'days6_normalTotal' => $days6_normalTotal,
                    'days7_normalTotal' => $days7_normalTotal,
                    'normalTotal' => $normalTotal,
                    );
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('timesheet/list', $data);
        $this->load->view('templates/footer');
    }





    public function add(){
        // parse range.
        $index = intval($this->uri->segment(3));
        $timeRange = $this->getTimeRangeKey($index);
        $startTime = $this->getWeekStartTime($index);

        $projectId = intval($this->input->post('pid'));
        $taskId = intval($this->input->post('tid'));
        if($projectId < 1 || $taskId < 1){
            $array = array('status'=>'no', 'msg'=>'请选择项目/任务');
            echo json_encode($array);
            exit;
        }
        //@todo 检查taskid 合法性：（查询Task表）.
        $array = array(
                        'pid' => 'project_id', 
                        'tid' => 'task_id', 
                        'day1_hours', 
                        'day2_hours', 
                        'day3_hours', 
                        'day4_hours', 
                        'day5_hours', 
                        'day6_hours', 
                        'day7_hours', 
                        'type' 
                    );
        // get uid.
        $user = $this->getSessionUserInfo();
        $uid = $user['id'];
        $model = $this->formDataToModel($array, 'post');
        $model['range_key'] = $timeRange;
        $model['startTime'] = $startTime;
        $this->checkTimeSheetValid($uid, 'add',  $model);
        $model['uid'] = $uid;
        // @TODO check privileges: 检查该用户是否有修改项目的权利.
        $result = $this->timesheet_model->add($model);
        echo json_encode($result);
        exit;
    }

    private function getTimeRangeKey($index=0){
        $range = $this->getWeekStartAndEndTime($index);
        return "{$range['start']}~{$range['end']}";
    }

    private function getWeekStartTime($index=0){
        $range = $this->getWeekStartAndEndTime($index);
        return $range['start']; 
    }

    private function getWeekStartAndEndTime($index=0){
        $timeStamp = time() - ($index*7*3600*24);
        $startTime = strtotime('this week', $timeStamp);
        $startDate = date('Y-m-d', $startTime);

        $endTime = strtotime('this sunday', $timeStamp);
        $endDate = date('Y-m-d', $endTime);

        return array('start'=>$startDate, 'end'=>$endDate);
    }

    private function checkTimeSheetValid($uid, $action, $model){
        $msg = '';
        $normalHours = 8;
        $overTimeHours = 16;
        $leaveHours = 8;
        $type = $model['type'];
        $timeRange = $model['range_key'];

		// normal+OH+leave <= 8
		if( $type!=2 && $action=="add" ) {
			$totalHoursExceptOverTime = $this->timesheet_model->getTotalTimeExceptOverTime($uid, $timeRange);
            if($model['day1_hours'] + intval($totalHoursExceptOverTime['day1_hours'])>$normalHours
            || $model['day2_hours'] + intval($totalHoursExceptOverTime['day2_hours'])>$normalHours
            || $model['day3_hours'] + intval($totalHoursExceptOverTime['day3_hours'])>$normalHours
            || $model['day4_hours'] + intval($totalHoursExceptOverTime['day4_hours'])>$normalHours
            || $model['day5_hours'] + intval($totalHoursExceptOverTime['day5_hours'])>$normalHours
            || $model['day6_hours'] + intval($totalHoursExceptOverTime['day6_hours'])>$normalHours
            || $model['day7_hours'] + intval($totalHoursExceptOverTime['day7_hours'])>$normalHours
            ){
                $msg = "正常项目工时+OH+休假每天不能超过 $normalHours 小时.";
            }
		}

        // get user current total timesheet.
        if($action == "add"){
            $currentHours = $this->timesheet_model->getByUidAndTimeRangeAndType($uid, $timeRange, $type);
        }else{
            $id = $model['id'];
            $currentHours = $this->timesheet_model->getByUidAndTimeRangeAndTypeExceptId($uid, $timeRange, $type, $id);
        }
        $model['day1_hours'] += intval($currentHours['day1_hours']);
        $model['day2_hours'] += intval($currentHours['day2_hours']);
        $model['day3_hours'] += intval($currentHours['day3_hours']);
        $model['day4_hours'] += intval($currentHours['day4_hours']);
        $model['day5_hours'] += intval($currentHours['day5_hours']);
        $model['day6_hours'] += intval($currentHours['day6_hours']);
        $model['day7_hours'] += intval($currentHours['day7_hours']);
   

        if( $type == 1 ){
            if($model['day1_hours']>$normalHours
            || $model['day2_hours']>$normalHours
            || $model['day3_hours']>$normalHours
            || $model['day4_hours']>$normalHours
            || $model['day5_hours']>$normalHours
            || $model['day6_hours']>$normalHours
            || $model['day7_hours']>$normalHours
            ){
                $msg = "正常工时每天不能超过 $normalHours 小时.";
            }
        }elseif( $type == 2 ){
            if($model['day1_hours']>$overTimeHours
            || $model['day2_hours']>$overTimeHours
            || $model['day3_hours']>$overTimeHours
            || $model['day4_hours']>$overTimeHours
            || $model['day5_hours']>$overTimeHours
            || $model['day6_hours']>$overTimeHours
            || $model['day7_hours']>$overTimeHours
            ){
                $msg = "加班工时每天不能超过 $overTimeHours 小时.";
            }
        }elseif( $type == 3  || $type == 4){
            if($model['day1_hours']>$leaveHours
            || $model['day2_hours']>$leaveHours
            || $model['day3_hours']>$leaveHours
            || $model['day4_hours']>$leaveHours
            || $model['day5_hours']>$leaveHours
            || $model['day6_hours']>$leaveHours
            || $model['day7_hours']>$leaveHours
            ){
                $msg = "OH/休假工时每天不能超过 $leaveHours 小时.";
            }
        }else{
            $msg = "工时类型错误.";
        }
        // 检查工时是否超出项目工时限制。
        if(empty($msg)){
            $pid = $model['project_id'];
            // 获取项目工时限制。
            $limitHours = $this->project_model->getLimitHoursByPid($pid);
            //获取当前已保存工时数。
            $usedHours = $this->timesheet_model->getUsedHoursByPid($pid);
            $leftHours = $limitHours-$usedHours;
            if( $leftHours < ($model['day1_hours']+$model['day2_hours']+$model['day3_hours']+$model['day4_hours']+$model['day5_hours']+$model['day6_hours']+$model['day7_hours'])){
                $msg = "填写工时超出项目限制，项目剩余工时 $leftHours 小时.";
            }
        }
        if(!empty($msg)){
            $result = array('status'=>'no', 'msg'=>$msg);
            echo json_encode($result);
            exit;
        }
    }



    /**
     * 删除 
     * 检查所有者
     * 检查状态.
     **/
    public function del(){
        $id = intval($this->uri->segment(3));
        $uid = $this->getSessionUid();
        $model = $this->timesheet_model->getTimeSheetById($id);

        if(empty($model) || $uid !== $model['uid']){
            $array = array('status'=>'no', 'msg'=>'只有工时单所有者有权限删除。');
            echo json_encode($array);
            exit;
        }
        // check status.
        $status = $model['approve_status'];
        if($status != 1 &&  $status!=5){
            $array = array('status'=>'no', 'msg'=>'单子已进入审批流程/审批成功，禁止删除');
            echo json_encode($array);
            exit;
        }
        // delete .
        $array = $this->timesheet_model->delById($id);
        echo json_encode($array);
        exit;
    }

    /**
     * 删除
     * 检查所有者
     * 检查状态.
     **/
    public function update(){
        $id = intval($this->uri->segment(3));
        $uid = $this->getSessionUid();
        $model = $this->timesheet_model->getTimeSheetById($id);

        if(empty($model) || $uid !== $model['uid']){
            $array = array('status'=>'no', 'msg'=>'只有工时单所有者有权限修改。');
            echo json_encode($array);
            exit;
        }
        // check status.
        $status = $model['approve_status'];
        if($status != 1 &&  $status!=5){
            $array = array('status'=>'no', 'msg'=>'单子已进入审批流程/审批成功，禁止修改。');
            echo json_encode($array);
            exit;
        }
        // update.
        $array = array(
                        'day1_hours', 
                        'day2_hours', 
                        'day3_hours', 
                        'day4_hours', 
                        'day5_hours', 
                        'day6_hours', 
                        'day7_hours', 
                    );
        $model = $this->formDataToModel($array, 'post');
        $model['id'] = $id;
        $dbModel = $this->timesheet_model->getTimeSheetById($id);
        if(empty($dbModel) || empty($dbModel['range_key'])){
            $array = array('status'=>'no', 'msg'=>'id错误。');
            echo json_encode($array);
            exit;
        }
        $model['range_key'] = $dbModel['range_key'];
        $model['type'] = $dbModel['type'];
        $model['project_id'] = $dbModel['project_id'];
        $this->checkTimeSheetValid($uid, 'update',  $model);
        $array = $this->timesheet_model->updateById($id, $model);
        echo json_encode($array);
        exit;
    }
    
    /** 领导审批单子 **/
    public function authApprove(){
        // 检查参数.
        $ids = $this->input->post('ids');
        $idsStr = implode(',', $ids);
        if(!preg_match('/^[0-9,]+$/', $idsStr)){
            $array = array('status'=>'no', 'msg'=>'格式错误');
            echo json_encode($array);
            exit;
        }
        //
        $uid = $this->getSessionUid();
        $message = "";
        $matchCount = 0;
        $submitIds = array();
        $pids = array();

        $status_4 = array();
        $status_3 = array();
        $mailNotifyList = array();

        foreach($ids as $id){
            $model = $this->timesheet_model->getTimeSheetById($id);
            if(empty($model)){
                continue;
            }
            $status = $model['approve_status'];
            $pid = $model['project_id'];
            $project = $this->project_model->getById($pid);
            if(empty($project)){
                continue;
            }
            // 一级审批的
            if($status==2 && $project['pm'] == $uid){
                $matchCount++;
                if($project['dm'] == 0  ||  $project['dm']==$uid){
                    $status_4[] = array('id'=>$id, 'uid'=>$model['uid']);
                    $mailNotifyList[] = $model;
                }else{
                    $status_3[] = array('id'=>$id, 'uid'=>$model['uid']);
                }
                // update to 
            }
            // 二级审批的.
            if($status==3 && $project['dm'] == $uid){
                $matchCount++;
                $status_4[] = array('id'=>$id, 'uid'=>$model['uid']);
                $mailNotifyList[] = $model;
            }
            /**
            if(empty($model) || $uid !== $model['uid']){
                continue;
            }
            if($model['approve_status'] != 1 &&  $model['approve_status']!=5){
                continue;
            }
            $matchCount++;
            $submitIds[] = $id;
            **/
        }
        //
        // update
        $status = 'no';
        if($matchCount>0){
            // update status_4. 
            if(!empty($status_4)){
                $result = $this->timesheet_model->submitApprove($status_4, '4');
                //@todo mail.
                $this->timesheet_model->sendSuccessMail($status_4, $uid);
            }
            if(!empty($status_3)){
                $result = $this->timesheet_model->submitApprove($status_3, '3');
            }
            $status = $result ? 'ok' : 'no';
        }
        if($status == 'ok'){
            $array = array("status"=>"ok", "msg"=>"成功批准 $matchCount 个工时单。", 'data'=>$submitIds);
        }else{
            $array = array("status"=>"no", "msg"=>"没有可批准的工单。");
        }
        echo json_encode($array);
        exit;


    }



    public function submitApprove(){
        // 检查参数.
        $ids = $this->input->post('ids');
        $idsStr = implode(',', $ids);
        if(!preg_match('/^[0-9,]+$/', $idsStr)){
            $array = array('status'=>'no', 'msg'=>'格式错误');
            echo json_encode($array);
            exit;
        }
        //
        $uid = $this->getSessionUid();
        $message = "";
        $matchCount = 0;
        $submitIds = array();
        $toSubmitHours = array();
        $timeRange = '';
        // set error reporting.
        //error_reporting(E_ERROR | E_WARNING | E_PARSE);
        foreach($ids as $id){
            if(empty($id)){
                continue;
            }
            $model = $this->timesheet_model->getTimeSheetById($id);
            $timeRange = $model['range_key'];
            if(empty($model) || $uid !== $model['uid']){
                continue;
            }
            if($model['approve_status'] != 1 &&  $model['approve_status']!=5){
                continue;
            }
            //$this->checkTimeSheetValid($uid, 'add',  $model);
            $matchCount++;
            $submitIds[] = $id;
        }
        // 检查 8 小时.
        if($matchCount>0){
            $submittedHours = $this->timesheet_model->getSubmittedTimeSheet($uid, $timeRange, $submitIds);
            $otSubmittedHours = $this->timesheet_model->getOTSubmittedTimeSheet($uid, $timeRange, $submitIds);
            //
            if($submittedHours){
                if( ($submittedHours['day1_hours']!=0 && $submittedHours['day1_hours']!=8 )
                    or ($submittedHours['day2_hours']!=0 && $submittedHours['day2_hours']!=8 )
                    or ($submittedHours['day3_hours']!=0 && $submittedHours['day3_hours']!=8 )
                    or ($submittedHours['day4_hours']!=0 && $submittedHours['day4_hours']!=8 )
                    or ($submittedHours['day5_hours']!=0 && $submittedHours['day5_hours']!=8 )
                    or ($submittedHours['day6_hours']!=0 && $submittedHours['day6_hours']!=8 )
                    or ($submittedHours['day7_hours']!=0 && $submittedHours['day7_hours']!=8 )
                ){
                    $array = array("status"=>"no", "msg"=>"正常工时 + OH + 休假工时应 = 8小时。");
                    echo json_encode($array);
                    exit;
                }
            }
            if($otSubmittedHours){
                if( ($otSubmittedHours['day1_hours']>16 )
                    or ($otSubmittedHours['day2_hours']>16 )
                    or ($otSubmittedHours['day3_hours']>16 )
                    or ($otSubmittedHours['day4_hours']>16 )
                    or ($otSubmittedHours['day5_hours']>16 )
                    or ($otSubmittedHours['day6_hours']>16 )
                    or ($otSubmittedHours['day7_hours']>16 )
                ){
                    $array = array("status"=>"no", "msg"=>"加班工时不能超过 16 小时。");
                    echo json_encode($array);
                    exit;
                }
            }
        }
        // update
        $status = 'no';
		//simon
		$msg = '';
        if($matchCount>0){
            //$result = $this->timesheet_model->submitApprove($ids);
			$sids = array();
			foreach($submitIds as $id) {
				$sids[] = array('id'=>$id);
			}
            $result = $this->timesheet_model->submitApprove($sids);
            if($result['status'] == "ok"){
                $status = 'ok';
				//simon
				$msg = $result['msg'];
            }
        }
        if($status == 'ok'){
            $array = array("status"=>"ok", "msg"=>"成功提交 $matchCount 个工时单。", 'data'=>$submitIds);
        }else{
            $array = array("status"=>"no", "msg"=>"没有可提交的工单。");
        }
        echo json_encode($array);
        exit;
    }


 
    /** 审批不通过 **/
    public function rejectApprove(){
        // 检查参数.
        $ids = $this->input->post('ids');
        // @todo 安全性检查.
        $comments = $this->input->post('comments');

        $idsStr = implode(',', $ids);
        if(!preg_match('/^[0-9,]+$/', $idsStr)){
            $array = array('status'=>'no', 'msg'=>'格式错误');
            echo json_encode($array);
            exit;
        }
        //
        $uid = $this->getSessionUid();
        $message = "";
        $matchCount = 0;
        $submitIds = array();
        $pids = array();

        $status_5 = array();
        $status_6 = array();

        foreach($ids as $id){
            $model = $this->timesheet_model->getTimeSheetById($id);
            if(empty($model)){
                continue;
            }
            $status = $model['approve_status'];
            $pid = $model['project_id'];
            $project = $this->project_model->getById($pid);
            if(empty($project)){
                continue;
            }
            // 一级审批的
            if($project['pm'] == $uid){
                //$status_5[] = $id;
                $status_5[] = array('id'=>$id, 'uid'=>$model['uid']);
                $matchCount++;
            }elseif($project['dm'] == $uid){
                //$status_6[] = $id;
                $status_6[] = array('id'=>$id, 'uid'=>$model['uid']);
                $matchCount++;
            }
        }
        // update
        $status = 'no';
        if($matchCount>0){
            if(!empty($status_6)){
                $result = $this->timesheet_model->submitApprove($status_6, '6', $comments);
            }
            if(!empty($status_5)){
                $result = $this->timesheet_model->submitApprove($status_5, '5', $comments);
            }
            $status = $result ? 'ok' : 'no';
        }
        if($status == 'ok'){
            $array = array("status"=>"ok", "msg"=>"驳回 $matchCount 个工时单。", 'data'=>$submitIds);
            if(!empty($status_5)){
	        		$this->timesheet_model->sendRejectMail($status_5, $uid);
	        	}
            if(!empty($status_6)){
	        		$this->timesheet_model->sendRejectMail($status_6, $uid);
	        	}
        }else{
            $array = array("status"=>"no", "msg"=>"审批失败。");
        }
        echo json_encode($array);
        exit;


    }





    // 审批
    public function approve(){
        $user  = $this->getSessionUserInfo();
        // pid & type
        $pid = intval($this->uri->segment(3));
        $typeId = intval($this->uri->segment(4));
        $pid = intval($pid)>0? intval($pid): 0;
        $typeId = intval($typeId)>0? intval($typeId): 0 ;

        $uid = $user['id'];
        $filters = array('pid'=>$pid);
        //$type = 1;
        // get approve list.
        $timeSheetList = $this->timesheet_model->getApproveTimeSheetByUidAndType($uid, $typeId, $filters);
        $projectList = $this->project_model->getApproveProjectList($uid);
        $data = array(
                    'timeSheetList' => $timeSheetList,
                    'projectList' => $projectList,
                    'sel_pid' => $pid,
                    'sel_typeId' => $typeId,
                    );
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('timesheet/approve', $data);
        $this->load->view('templates/footer');
    }

    public function report(){
        $user  = $this->getSessionUserInfo();
        $tprojectList = $this->timesheet_model->getUserPartProjects($user);

        $projectList = array();
        $projectList[] = array( 'id'=>-1, 'name'=>'OVERHEAD');
        $projectList[] = array( 'id'=>-2, 'name'=>'LEAVE'); 
        //show_error(implode(', ', $projectList));
        foreach ($tprojectList as $p ){
            if ( $p['name'] != 'OVERHEAD' && $p['name'] != 'LEAVE' )
                $projectList[] = $p;
        }

        $pid = intval($this->uri->segment(3));
        $dept = intval($this->uri->segment(4));
        $startTime = ($this->uri->segment(5));
        $endTime = ($this->uri->segment(6));
        $searchName = ($this->uri->segment(7));
        $employeeList = $this->employee_model->getListBaseInfo(array(),0,10000);
        $filterUid = 0;
        if(!empty($searchName)){
            $filterUid = $this->employee_model->getIdByUserName($searchName);
        }
        if(empty($startTime)){
            $startTime = date('Y-m-01 H:i:s', strtotime('-90 day'));
        }else{
            $startTime = date('Y-m-d H:i:s', strtotime($startTime));
        }
        if(empty($endTime)){
            $startTime = date('Y-m-d H:i:s');
        }else{
            $endTime = date('Y-m-d H:i:s', strtotime($endTime));
        }
        //@todo validate startTime & endTime.

        /**
        if(empty($pid) && count($projectList)>0){
            $pid = $projectList[0]['id'];
        }
        **/
        $filters = array(
                        'pid'=>$pid,
                        'dept'=>$dept,
                        'start'=>$startTime,
                        'end'=>$endTime,
                        'filterUid'=>$filterUid,
                    );
        //$project = $this->project_model->getById($pid);
        $deptList = $this->dict_model->getDictList('DeptType');
        $data = array();
        $template = 'report';
        $timeSheetList = $this->timesheet_model->groupTimeSheetByPid($filters, $user);
        $userList = $this->timesheet_model->extractUserList($timeSheetList);
        $monthList = $this->timesheet_model->extractMonthList($timeSheetList);
		//, 404, implode(', ', $ProjectList));
        if(!empty($startTime)){
            $startTime = date('Y-m-d', strtotime($startTime));
            $endTime = date('Y-m-d', strtotime($endTime));
        }
        $data = array(
                    'reportList' => $timeSheetList,
                    'userList' => $userList,
                    'monthList' => $monthList,
                    'employeeList' => $employeeList,
                    //'projectName' => $project['name'],
                    'projectList' => $projectList,
                    'sel_pid' => $pid,
                    'sel_dept' => $dept,
                    'sel_start' => $startTime,
                    'sel_end' =>  $endTime,
                    'deptList' => $deptList,
                    'search_username' => $searchName,
                    );
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('timesheet/'.$template, $data);
        $this->load->view('templates/footer');
    }



    public function export(){
        $user  = $this->getSessionUserInfo();
        $projectList = $this->timesheet_model->getUserPartProjects($user);
        $pid = intval($this->uri->segment(3));
        $dept = intval($this->uri->segment(4));
        $startTime = ($this->uri->segment(5));
        $endTime = ($this->uri->segment(6));
        $searchName = ($this->uri->segment(7));
        $filterUid = 0;
        if(!empty($searchName)){
            $filterUid = $this->employee_model->getIdByUserName($searchName);
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
                        'pid'=>$pid,
                        'dept'=>$dept,
                        'start'=>$startTime,
                        'end'=>$endTime,
                        'filterUid'=>$filterUid,
                    );
        //$timeSheetList = $this->timesheet_model->groupTimeSheetByPid($pid, $user);
        $timeSheetList = $this->timesheet_model->exportByFilters($filters, $user);
        $timeSheetList = iconv('utf-8', 'gbk', $timeSheetList);
        header("Content-Type: application/vnd.ms-excel; charset=gbk");
        //header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        $this->load->helper('download_helper');
        force_download('crm.csv', $timeSheetList);
        //echo json_encode($timeSheetList);
    }

    public function testSendEmail(){
        $array1 = array('id'=>'209', 'uid'=>'13');
        $array2 = array('id'=>'307', 'uid'=>'13');
        $status_4[] = $array1;
        $status_4[] = $array2;
        $authUid = '3';
        $ret = $this->timesheet_model->sendSuccessMail($status_4, $authUid);
        var_dump($ret);
    }




}
