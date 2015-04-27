<?php

class TimeSheet_model extends CI_Model {

    private $table = 'TimeSheet';

    public function __construct(){
        $this->load->database();
        $this->config->load('myconfig');
    }

    // insert into table.
    function add($data){
        $success = $this->db->insert($this->table, $data); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';
        if($errno != 0){
            $status = 'no';
            $message = "添加失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

    // get list by uid and type.
    function getListByUidAndType($uid, $timeRange, $type){
        $uid = intval($uid);
        $type = intval($type);
        $sql = "
               select ts.id, ts.project_id, ts.task_id,ts.type as type, day1_hours, day2_hours,day3_hours,day4_hours,day5_hours,day6_hours,day7_hours, p.name as projectName,pst.name as approveName,(day1_hours+day2_hours+day3_hours+day4_hours+day5_hours+day6_hours+day7_hours) as total_hours,approve_comments,ttb.name as taskName,tst.name as tsTypeName
               from TimeSheet ts
               left join Task t on t.id=ts.task_id
               left join TaskType ttb on ttb.id=ts.task_id
               left join Project p on p.id=ts.project_id
               left join TimeSheet_Type tst on tst.id=ts.type
               left join TimeSheetStatusType pst on pst.id= ts.approve_status
               where ts.uid=$uid and range_key='$timeRange' and ts.status='3'
               order by ts.type asc;
               ";
		//show_error($sql);
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }
        return $data;
    }


    // approve
    function getApproveTimeSheetByUidAndType($uid, $type, $filters=array()){
        $uid = intval($uid);
        $type = intval($type);
        //
        $pid = intval($filters['pid']);
        $typeFilter = '';
        $projectFilter = '';
        if($pid > 0){
            $projectFilter = " id=$pid and ";
        }
        if($type > 0){
            $typeFilter = " ts.type=$type and  ";
        }
        // get project list.
        $sql = "select *  from Project where $projectFilter (pm=$uid or dm=$uid) and status=3";
        $query = $this->db->query($sql); 
        $pids = array();
        foreach ($query->result_array() as $row){
            $projectList[] = $row;
            $pids[] = $row['id'];
        }
        if(empty($pids))
            return array();
        //
        $pids = implode(',', $pids);
        $sql = "
               select ts.id, ts.project_id, e.name as employeeName,ts.task_id, tt.id as tsType,tt.name as tsTypeName, day1_hours, day2_hours,day3_hours,day4_hours,day5_hours,day6_hours,day7_hours, range_key, ttb.name as taskName,p.name as projectName,pst.name as approveName,(day1_hours+day2_hours+day3_hours+day4_hours+day5_hours+day6_hours+day7_hours) as total_hours
               from TimeSheet ts
               left join Task t on t.id=ts.task_id
               left join TaskType ttb on ttb.id=ts.task_id
               left join Project p on p.id=ts.project_id
               left join Employee e on e.id=ts.uid
               left join TimeSheet_Type tt on ts.type=tt.id
               left join TimeSheetStatusType pst on pst.id= ts.approve_status
               where ts.project_id in ($pids) and $typeFilter ts.status='3' and ((approve_status=2 and p.pm=$uid ) or (approve_status=3 and p.dm=$uid));
               ";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }
        return $data;
    }


    function getTimeSheetById($id){
        $id = intval($id);
        $query = $this->db->get_where($this->table, array('id' => $id), 1, 0);
        $data = array();
        foreach ($query->result_array() as $row){
            return $row;
        }
        return array();
    }

    function updateById($id, $data){
        $this->db->where('id', $id);
        $success = $this->db->update($this->table, $data); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';

        if($errno != 0){
            $status = 'no';
            $message = "更新失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

    function submitApprove($items, $approveStatus='2', $comments=''){

        $ids = array();
        foreach($items as $itm){
            // 兼容老数据格式只传ids.
			/*
            if(empty($itm['id'])){
        		$idsStr = implode("#", $items);
        		return array('status'=>'ok', 'msg'=>$idsStr);
                $ids = $items;
                break;
            }
			*/
            $ids[] = $itm['id'];
        }

        $approveStatus = intval($approveStatus);
        $ids = implode(",", $ids);
        $sql = "update TimeSheet set approve_status=$approveStatus ,approve_comments='$comments' where id in ($ids)";
        $query = $this->db->query($sql); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';
        if($errno != 0){
            $status = 'no';
            $message = "提交审批失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }



    function delById($id){
        $data = array('status'=>'9');
        $this->db->where('id', $id);
        $success = $this->db->update($this->table, $data); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';

        if($errno != 0){
            $status = 'no';
            $message = "更新失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

	
    function getByUidAndTimeRangeAndType($uid, $range, $type){
        $type = intval($type);
        $uid = intval($uid);
        $sql = "select sum(day1_hours) as day1_hours,sum(day2_hours)  as day2_hours,sum(day3_hours)  as day3_hours,sum(day4_hours)  as day4_hours,sum(day5_hours)   as day5_hours,sum(day6_hours)   as day6_hours,sum(day7_hours)  as day7_hours  from TimeSheet where uid=$uid and range_key='$range' and type=$type and status=3 limit 0,1";
        return $this->getSingleResultBySql($sql);
    }


    function getByUidAndTimeRangeAndTypeExceptId($uid, $range, $type, $id){
        $id = intval($id);
        $type = intval($type);
        $uid = intval($uid);
        $sql = "select sum(day1_hours) as day1_hours,sum(day2_hours)  as day2_hours,sum(day3_hours)  as day3_hours,sum(day4_hours)  as day4_hours,sum(day5_hours)   as day5_hours,sum(day6_hours)   as day6_hours,sum(day7_hours)  as day7_hours  from TimeSheet where uid=$uid and range_key='$range' and type=$type and id!=$id and status=3 limit 0,1;";
        return $this->getSingleResultBySql($sql);
    }


    function getTotalTimeExceptOverTime($uid, $range){
        $type = 2;
        $uid = intval($uid);
        $sql = "select sum(day1_hours) as day1_hours,sum(day2_hours)  as day2_hours,sum(day3_hours)  as day3_hours,sum(day4_hours)  as day4_hours,sum(day5_hours)   as day5_hours,sum(day6_hours)   as day6_hours,sum(day7_hours)  as day7_hours  from TimeSheet where uid=$uid and range_key='$range' and type!=$type and status=3 limit 0,1";
        return $this->getSingleResultBySql($sql);
    }

    function getTimeSheetByPid($filters, $user){/*{{{*/
        $pid = intval($filters['pid']);
        $dept  = intval($filters['dept']);
        $startTime = ($filters['start']);
        $endTime = ($filters['end']);
        $filterUid = $filters['filterUid'];

        $filterStr = "";
        if($pid>0){
            $filterStr = " ts.project_id=$pid and ";
        }
        else if($pid==-1){
            //todo
            $filterStr = " ts.type=3 and";
        }
        else if($pid==-2){
            $filterStr = " ts.type=4 and";
        }
        else{
            $pids = array();
            $projectList = $this->timesheet_model->getUserPartProjects($user);
            foreach($projectList as $pro){
               $pids[] = $pro['id']; 
            }
            if(!empty($pids)){
                $pids = implode(',',$pids);
                $filterStr = " ts.project_id in ($pids) and ";
            }
        }
        if($dept>0){
            $filterStr .= " e.department = $dept and ";
        }
        if($filterUid >0 ){
            $filterStr .= " e.id = $filterUid and ";
        }
        if(!empty($startTime)){
            $min_startTime = date('Y-m-d H:i:s', strtotime($startTime)-604800);
            $filterStr .= " ts.startTime>='{$min_startTime}' and ts.startTime<='$endTime' and  ";
        }
        //
        $sql = "
                select ts.uid,ts.type, e.name as employeeName,p.name as projName, tt.name as taskName, dt.name as deptName, range_key,day1_hours, day2_hours,day3_hours,day4_hours,day5_hours,day6_hours,day7_hours
                from TimeSheet ts
                left join Employee e on ts.uid=e.id
                left join DeptType dt on e.department=dt.id
                left join Project p on ts.project_id=p.id
		left join TaskType tt on tt.id=ts.task_id
                where $filterStr ts.approve_status=4 and ts.status='3'
                order by ts.startTime asc;
               ";
		//show_error($sql);

        $results = $this->getResultBySql($sql);
        if(!$results){
           return array(); 
        }
        return $results;
    }/*}}}*/


    function groupTimeSheetByPid($filters, $user=array(), $format='Y-m'){
        // 
        $start = strtotime($filters['start']);
        $end = strtotime($filters['end']);

        $results = $this->getTimeSheetByPid($filters, $user);
        $newResult = array();
        foreach($results as $result){
            $range = $result['range_key'];
            $uid = $result['uid'];
            $type = $result['type'];
            list($startDate, $endDate) = explode('~', $range);
            $startTime = strtotime($startDate);
            $endTime = strtotime($endDate);
            if ( $endTime < $startTime ) {
                continue;
            }
            $day2Month = array();
            $day2Month['day1_hours'] = date($format, strtotime('+0 days', $startTime));
            $day2Month['day2_hours'] = date($format, strtotime('+1 days', $startTime));
            $day2Month['day3_hours'] = date($format, strtotime('+2 days', $startTime));
            $day2Month['day4_hours'] = date($format, strtotime('+3 days', $startTime));
            $day2Month['day5_hours'] = date($format, strtotime('+4 days', $startTime));
            $day2Month['day6_hours'] = date($format, strtotime('+5 days', $startTime));
            $day2Month['day7_hours'] = date($format, strtotime('+6 days', $startTime));

            try{
                error_reporting(!E_NOTICE);
                $i = 0;
                foreach($day2Month as $day=>$month) {
                    $dayTime = strtotime('+'.$i.' days', $startTime);
                    $i = $i + 1;
                    if ( !empty($start) && ($dayTime < $start || $dayTime > $end) )
                        continue;

                    $newResult[$month][$uid][$type]['total'] += intval($result[$day]);
                    $newResult[$month][$uid]['employeeName'] = $result['employeeName'];
                    $newResult[$month][$uid]['deptName'] = $result['deptName']; //error
                    $newResult[$month][$uid]['month'] = $month;
                    $newResult[$month][$uid]['projName'] = $result['projName'];
                    $newResult[$month][$uid]['taskName'] = $result['taskName'];
                }
            }catch(Exception $e){
            }
        }
        return $newResult;
    }

    function groupTimeSheetByPid4Export($filters, $user=array(), $format){
        // 
        $start = strtotime($filters['start']);
        $end = strtotime($filters['end']);

        $results = $this->getTimeSheetByPid($filters, $user);
        $newResult = array();
        foreach($results as $result){
            $range = $result['range_key'];
            $uid = $result['uid'];
            $type = $result['type'];
            $projName = $result['projName'];
            $taskName = $result['taskName'];
            list($startDate, $endDate) = explode('~', $range);
            $startTime = strtotime($startDate);
            $endTime = strtotime($endDate);
            if ( $startTime > $endTime) { 
                continue;
            }
            $m1_hours = date($format, strtotime('+0 days', $startTime));
            $m2_hours = date($format, strtotime('+1 days', $startTime));
            $m3_hours = date($format, strtotime('+2 days', $startTime));
            $m4_hours = date($format, strtotime('+3 days', $startTime));
            $m5_hours = date($format, strtotime('+4 days', $startTime));
            $m6_hours = date($format, strtotime('+5 days', $startTime));
            $m7_hours = date($format, strtotime('+6 days', $startTime));

            try{
                error_reporting(!E_NOTICE);
                $dayList = array($m1_hours=>'day1_hours', $m2_hours=>'day2_hours', $m3_hours=>'day3_hours', $m4_hours=>'day4_hours', $m5_hours=>'day5_hours', $m6_hours=>'day6_hours', $m7_hours=>'day7_hours');
                $i = 0;
                foreach($dayList as $date=>$day) {
                    $dayTime = strtotime('+'.$i.' days', $startTime);
                    $i = $i + 1;
                    if ( !empty($start) && ($dayTime < $start || $dayTime > $end) )
                        continue;

                    $newResult[$date][$uid][$projName][$taskName] += intval($result[$day]);
                    $newResult[$date][$uid]['employeeName'] = $result['employeeName'];
                    $newResult[$date][$uid]['deptName'] = $result['deptName']; 
                    $newResult[$date][$uid]['month'] = $date;
                }
            }catch(Exception $e){
            }
        }
        return $newResult;
    }

    function getSubmittedTimeSheet($uid, $timeRange, $submitIds){/*{{{*/
        $uid = intval($uid);
        $submitIds = implode(',', $submitIds);
        $sql = "
        select sum(day1_hours) as day1_hours, sum(day2_hours) as day2_hours, sum(day2_hours) as day2_hours , sum(day3_hours) as day3_hours , sum(day4_hours) as day4_hours , sum(day5_hours) as day5_hours , sum(day6_hours) as day6_hours , sum(day7_hours) as day7_hours   
        from TimeSheet 
        where uid=$uid and  range_key='$timeRange'
        and type!=2 and 
        (   (approve_status=2 or approve_status=3 or approve_status=4)
            or id in ($submitIds) 
        )
               ";
        return $this->getSingleResultBySql($sql);
    }/*}}}*/


    function getOTSubmittedTimeSheet($uid, $timeRange, $submitIds){/*{{{*/
        $uid = intval($uid);
        $submitIds = implode(',', $submitIds);
        $sql = "
        select sum(day1_hours) as day1_hours, sum(day2_hours) as day2_hours, sum(day2_hours) as day2_hours , sum(day3_hours) as day3_hours , sum(day4_hours) as day4_hours , sum(day5_hours) as day5_hours , sum(day6_hours) as day6_hours , sum(day7_hours) as day7_hours   
        from TimeSheet 
        where uid=$uid and  range_key='$timeRange'
        and type=2 and 
        (   (approve_status=2 or approve_status=3 or approve_status=4)
            or id in ($submitIds) 
        )
               ";
        return $this->getSingleResultBySql($sql);
    }/*}}}*/



    function getUserPartProjects($user){/*{{{*/
        $uid = $user['id'];
        $uid = intval($uid);
        $role = intval($user['role']); 
        $filterStr = "";
        if($role==6){
            $filterStr = " ";
			return array();
        }else{
            $filterStr = " (ts.uid=$uid or p.owner=$uid or p.pm=$uid or p.dm=$uid )  and ";
        }
        $sql = "
               select distinct(p.id) as id, p.name as name
               from TimeSheet ts
               left join Project p on p.id=ts.project_id
               left join TimeSheetStatusType pst on pst.id= ts.approve_status
               where  $filterStr ts.status=3 and p.status=3 ;
               ";
		//show_error($sql);
        return $this->getResultBySql($sql);
    }/*}}}*/

    function getUsedHoursByPid($pid){/*{{{*/
        $pid = intval($pid);
        $sql = "
               select sum(day1_hours+day2_hours+day3_hours+day4_hours+day5_hours+day6_hours+day7_hours)as total from TimeSheet where project_id={$pid} and status=3 and approve_status<5 ;
               ";
        $result = $this->getSingleResultBySql($sql);
        if(!$result){
            return 0;
        }
        return $result['total'];
    }/*}}}*/



    function sendSuccessMail($successIds, $authUid){
        $uids = array();
        foreach($successIds as $item){
            $uid = $item['uid'];
            $uids[$uid][] = $item['id'];
        }
        $subject = "您的工时单已经审批成功";
        $employeeModel = new Employee_model();
        foreach($uids as $key=>$idList){
            $count = count($idList);
            $idsStr = implode(',', $idList);
            $contents = "您的 $count 个工时单【{$idsStr}】已经通过审批。";
            
            $employee = $employeeModel->getById('Employee', $key);
            if(!$employee)
                continue;
            $email = $employee['mail'];
            //$email = 'pqcc@163.com';
            $this->sendMail($email, $subject, $contents);
        }
        return true;
    }

    function sendRejectMail($rejectIds, $authUid){
        $uids = array();
        foreach($rejectIds as $item){
            $uid = $item['uid'];
            $uids[$uid][] = $item['id'];
        }
        $subject = "您的工时单被驳回";
        $employeeModel = new Employee_model();
        foreach($uids as $key=>$idList){
            $count = count($idList);
            $idsStr = implode(',', $idList);
            $contents = "您的 $count 个工时单【{$idsStr}】未能通过审批。";
            
            $employee = $employeeModel->getById('Employee', $key);
            if(!$employee)
                continue;
            $email = $employee['mail'];
            //$email = 'pqcc@163.com';
            $this->sendMail($email, $subject, $contents);
        }
        return true;
    }
    private function sendMail($toEmail, $subject, $content){
        $fromEmail = 'crm@zhlbt.com';
        $fromName = '公司管理系统';
        $this->load->library('email');
        $this->email->from($fromEmail, $fromName);
        $this->email->to($toEmail); 
        //$this->email->cc('another@another-example.com'); 
        $this->email->subject($fromName);
        $this->email->message($content);  
        $this->email->send();
    }


    function extractUserList($timeSheetList){
        $userList = array();
        // day => item
        foreach($timeSheetList as $item){
            foreach($item as $uid=>$info){
                $userList[$uid] = $info;
            }
            //show_error(implode(', ', array_keys($userLists)));
        }
        return $userList;
    }

    function extractMonthList($timeSheetList){
        $list = array();
        foreach($timeSheetList as $key=>$item){
            $list[$key]["key"] = $key;
        }
        return $list;
    }

    function exportByFilters($filters, $user){
            $pid = $filters['pid'];
            $timeSheetList = $this->groupTimeSheetByPid4Export($filters, $user, 'Y.m.d');
            $userList = $this->extractUserList($timeSheetList);
            $dayList = $this->extractMonthList($timeSheetList);//dayList
            // echo header.
            $result = "";
            $result .= "部门名称,姓名,项目名称,任务名称,日期,工时 \r\n";
            //
            foreach($dayList as $day){
                $dayKey = $day['key'];
                $timeSheet = $timeSheetList[$dayKey];
                foreach($userList as $uid=>$user){
                    $projList = array_keys($timeSheet[$uid]);
                    foreach($projList as $proj) {
                        $taskList = array_keys($timeSheet[$uid][$proj]);
                        //show_error(implode(', ', $taskList))
                        foreach($taskList as $task) {
                            $hours = intval($timeSheet[$uid][$proj][$task]);
                            $result .= $user['deptName'] . ',' . $user['employeeName'];
                            $result .= ", $proj, $task, $dayKey, $hours";
                            $result .= "\r\n";
                        }
                    }
                }
            }
            return $result;
    }

    //get timesheet list filter by pid and time
    function getTimeSheetByPid4Finance($filters) {
        $pid = intval($filters['pid']);
        $startTime = ($filters['start']);
        $endTime = ($filters['end']);

        $filterStr = "";
        if($pid>0){
            $filterStr = " ts.project_id=$pid and ";
        }
        else if($pid==-1){// for overhead
            //todo
            $filterStr = " ts.type=3 and";
        }
        else if($pid==-2){// for leave
            $filterStr = " ts.type=4 and";
        }
        else{
            $pids = array();
            $projectList = $this->timesheet_model->getProjectListForFinance();
            foreach($projectList as $pro){
               $pids[] = $pro['id'];
            }
            if(!empty($pids)){
                $pids = implode(',',$pids);
                $filterStr = " ts.project_id in ($pids) and ";
            }
        }

        if(!empty($startTime)){
            $min_startTime = date('Y-m-d H:i:s', strtotime($startTime)-604800); // 604800 is one week
            $filterStr .= " ts.startTime>='{$min_startTime}' and ts.startTime<='$endTime' and  ";
        }
        
        $sql = "select ts.uid,ts.type, employeeNo, employeeName, positionName, p.name as projName, p.no as projNo,
                range_key, day1_hours, day2_hours,day3_hours,day4_hours,day5_hours,day6_hours,day7_hours
                from TimeSheet ts
                left join 
                (select Employee.id as eid, no as employeeNo, Employee.name as employeeName, PositionType.name as positionName
                 from Employee 
                 left join PositionType on Employee.position=PositionType.id
                )ep on ts.uid=ep.eid
                left join Project p on ts.project_id=p.id
                where $filterStr ts.approve_status=4 and ts.status='3'
                order by ep.positionName;
               ";

        /* show_error($sql); */
        $results = $this->getResultBySql($sql);
        if(!$results){
           return array();
        }

        return $results;
    }

    function groupTimeSheetByPid4FinanceExport($filters, $format) 
    {
        //
        $start = strtotime($filters['start']);
        $end = strtotime($filters['end']);
        $monthList = $this->getMonthList($start, $end);

        $results = $this->getTimeSheetByPid4Finance($filters);
        $epTimeSheetList = array();
        $pjTimeSheetList = array();
        $pjNoList = array();
        foreach($results as $result){
            $range = $result['range_key'];
            $uid = $result['uid'];
            $type = $result['type'];
            $projName = $result['projName'];
            $projNo = $result['projNo'];
            $pjNoList[$projName] = $projNo;
            list($startDate, $endDate) = explode('~', $range);
            $startTime = strtotime($startDate);
            $endTime = strtotime($endDate);
            if ( $startTime > $endTime) {
                continue;
            }

            try{
                error_reporting(!E_NOTICE);
                $dayList = array('day1_hours', 'day2_hours', 'day3_hours', 
                                 'day4_hours', 'day5_hours', 'day6_hours', 'day7_hours');
                $i = 0;
                foreach($dayList as $day) {
                    $dayTime = strtotime('+'.$i.' days', $startTime);

                    $i = $i + 1;
                    if ( !empty($start) && ($dayTime < $start || $dayTime > $end) )
                        continue;

                    $dayTimeStr = date($format, $dayTime);
                    $monthStr = date("Y.m", $dayTime);
                    $epTimeSheetList[$uid]['pjList'][$projName]['dayList'][$dayTimeStr] += intval($result[$day]);
                    $epTimeSheetList[$uid]['pjList'][$projName]['monthList'][$monthStr] += intval($result[$day]);
                    $pjTimeSheetList[$projName][$monthStr] += intval($result[$day]);
                }
                $epTimeSheetList[$uid]['employeeName'] = $result['employeeName'];
                $epTimeSheetList[$uid]['employeeNo'] = $result['employeeNo'];
                $epTimeSheetList[$uid]['positionName'] = $result['positionName'];

            }catch(Exception $e){
            }
        }

        $this->alignTimeSheet($epTimeSheetList, $pjTimeSheetList, $monthList);

        return array("ep" => $epTimeSheetList, "pj" => $pjTimeSheetList, "monthList" => $monthList, "noList" => $pjNoList);
    }

    function exportEmployeeTimeSheet4Finance($filters) 
    {
        // uid => ("employeeName" => ename, "employeeNo" => eno, "positionName" => pname, 
        //         "pjList" => pjName => ("dayList" => date => time, "monthList" => month => time))
        // pjName => month => time
        $timeSheetList = $this->groupTimeSheetByPid4FinanceExport($filters, 'Y.m.d');
        $epTimeSheetList = $timeSheetList['ep'];
        $pjTimeSheetList = $timeSheetList['pj'];
        $employeeList = $this->getAllUids4Finance();
        $monthList = $timeSheetList['monthList'];
        $monthNum = count($monthList);
        $pjNameList = array_keys($pjTimeSheetList);
        $pjNum = count($pjNameList);
        $commas = "";
        $commasContent = "";
        for($i = 0; $i < $monthNum ; $i++) {
            $commas .= ",";
            $commasContent .= "0,";
        }
            
        // echo header.
        $result = "项目名称,,,";
        foreach($pjTimeSheetList as $pjName=>$timeSheet) {
            $normalizeName = str_replace(',', ';', $pjName);
            $result .= "$normalizeName" . $commas . ",";
        }

        //if no pid specified, need not count total of each month
        if ($filters['pid'] == 0) {
            $result .= "每人每月所有项目工时合计" . $commas . "每人工时合计";
        }
        $result .= "\r\n";
        $result .= "项目归属月份,,,";

        for($i = 0; $i < $pjNum; $i++) {
            foreach($monthList as $mon) {
                $result .= $mon . "月,";
            }
            $result .= "合计,";
        }

        //if no pid specified, need not count total of each month
        if($filters['pid'] == 0) {
            foreach($monthList as $mon) {
                $result .= $mon . "月,";
            }
            $result .= "合计,";
        }

        $result .= "\r\n";

        $eachProjectEachMonth = $this->initEachProjectEachMonth($pjNameList, $monthList);

        $partUids = array_keys($epTimeSheetList);
        foreach($employeeList as $employee) {
            $eid = $employee['id'];
            //employee not participate any project, fill with 0;
            if(!in_array($eid, $partUids)){
                if($filters['pid'] != 0) {
                    continue;
                }
                if (!$employee['positionName']) {
                    $employee['positionName'] = 'NULL';
                }
                $employee['employeeNo'] = "'".$employee['employeeNo'];
                $result .= $employee['positionName'] . "," . $employee['employeeNo'] . "," . $employee['employeeName'] . ",";
                foreach($pjNameList as $pjName) {
                    $result .= $commasContent . "0," ;
                }
                $result .= $commasContent . "0 \r\n" ;
                continue;
            }

            $ept = $epTimeSheetList[$eid];
            $employeeName = $ept['employeeName'];
            $employeeNo = "'".$ept['employeeNo'];
            $positionName = $ept['positionName'];
            if(!$positionName) {
                $positionName = 'NULL';
            }

            $result .= $positionName . "," . $employeeNo . "," . $employeeName . ",";

            $pjList = $ept['pjList'];
            $userPartPjNames = array_keys($ept['pjList']);
            $monthTotal = array();
            foreach($monthList as $mon) {
                $monthTotal[$mon] = 0;
            }

            foreach($pjNameList as $pjName) {
                if (!in_array($pjName, $userPartPjNames)) {
                    $result .= $commasContent . "0," ;
                    continue;
                }

                $pjMonthList = $ept['pjList'][$pjName]['monthList'];
                $userPartMons = array_keys($pjMonthList);
                $pjTotal = 0;
                foreach($monthList as $mon) {
                    if (!in_array($mon, $userPartMons)) {
                        $result .= "0,";
                    }else {
                        $result .= $pjMonthList[$mon] . ",";
                        $monthTotal[$mon] += $pjMonthList[$mon];
                        $pjTotal += $pjMonthList[$mon];
                        $eachProjectEachMonth[$pjName][$mon] += $pjMonthList[$mon];
                    }
                }
                $result .= $pjTotal . ",";
            }

            //if no pid specified, need not count total of each month
            if ($filters['pid'] == 0) {
                $employeeTotal = 0;
                foreach($monthList as $mon) {
                    $result .= $monthTotal[$mon] . ",";
                    $employeeTotal += $monthTotal[$mon];
                }
                $result .= $employeeTotal ;
            }
            $result .= "\r\n";
        }

        $result .= "各项目单月汇总,,,";
        $monthTotal = array();
        foreach($pjNameList as $pjName) {
            $total = 0;
            foreach($monthList as $mon) {
                $result .= $eachProjectEachMonth[$pjName][$mon] . ",";
                $total += $eachProjectEachMonth[$pjName][$mon];
                $monthTotal[$mon] += $eachProjectEachMonth[$pjName][$mon];
            }
            $result .= $total . ",";
        }

        //if no pid specified, need not count total of each month
        if ($filters['pid'] == 0) {
            $total = 0;
            foreach($monthList as $mon) {
                $result .= $monthTotal[$mon] . ",";
                $total += $monthTotal[$mon];
            }
            $result .= $total;
        }
        
        return $result;
    }

    function exportProjectTimeSheet4Finance($filters) {
        // pjName => month => time
        $timeSheetList = $this->groupTimeSheetByPid4FinanceExport($filters, 'Y.m.d');
        $pjTimeSheetList = $timeSheetList['pj'];
        $pjNoList = $timeSheetList['noList'];
        $monthList = $timeSheetList['monthList'];
        $monthNum = count($monthList);
        $pjNameList = array_keys($pjTimeSheetList);
        $pjNum = count($pjNameList);
        $commasContent = "";
        for($i = 0; $i < $monthNum + 1; $i++) {
            $commasContent .= "0,";
        }
        //echo header
        $result = "序号,项目名称,编号,";
        foreach($monthList as $mon) {
            $result .= $mon . "月工时,";
        }
        $result .= "工时合计\r\n";
        $seqNo = 0;
        $monthTotal = array();
        foreach($pjNameList as $pjName) {
            $seqNo += 1;
            $pno = $pjNoList[$pjName];
            $normalizeName = str_replace(',', ';', $pjName);
            $result .= $seqNo . "," . $normalizeName . "," . $pno . ",";
            $pjMonthList = $pjTimeSheetList[$pjName];
            $total = 0;
            $mList = array_keys($pjMonthList);
            foreach($monthList as $mon) {
                if(!in_array($mon, $mList)){
                    $result .= "0,";
                    $monthTotal[$mon] += 0;
                    continue;
                }

                $result .= $pjMonthList[$mon] . ",";
                $total += $pjMonthList[$mon];
                $monthTotal[$mon] += $pjMonthList[$mon];
            }
            $result .= $total . "\r\n";
        }
        $result .= ",合计,,";
        $allTotal = 0;
        foreach($monthList as $mon) {
            $result .= $monthTotal[$mon] . ",";
            $allTotal += $monthTotal[$mon];
        }
        $result .= $allTotal;

        return $result;
    }

    function getAllUids4Finance() {
        $sql = "select e.id as id, e.no as employeeNo, e.name as employeeName, p.name as positionName
        from Employee e
        left join PositionType p on e.position=p.id
        where  e.status='3' 
        and no not in ('0000000', '0000001', '0000002', '0000003', '0000004', '0000005', '0000006')
        order by e.position";

        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }
        return $data;
    }

    function getProjectListForFinance() {
        $sql = "select p.id,p.no,p.name
        from Project p
        where  p.status='3'
        and type not in (8,9)
        limit 0,10000";
        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }
        return $data;
    }

    function getMonthList($start, $end) {
        $monthList = array();

        $startTime = strtotime(date('Ym01', $start));
        $endTime = strtotime(date('Ym01', $end));

        while($startTime <= $end) {
            $month = date('Y.m', $startTime );
            array_push($monthList, $month);
            $startTime = strtotime('next month', $startTime);
        }

        return $monthList;
    }

    function alignTimeSheet($epTimeSheetList, $pjTimeSheetList, $monthList) 
    {
        foreach($epTimeSheetList as $ept) {
            $pjList = $ept['pjList'];
            foreach($pjList as $pj) {
                $mList = $pj['monthList'];
                foreach($monthList as $month) {
                    if (!in_array($month, array_keys($mList) )) {
                        $mList[$month] = 0;
                    }
                }
            }
        }

        foreach($pjTimeSheetList as $mList) {
            foreach($monthList as $month) {
                if (!in_array($month, array_keys($mList) )) {
                    $mList[$month] = 0;
                }
            }
        }
    }

    function initEachProjectEachMonth($pjNameList, $monthList) {
        $eachProjectEachMonth = array();
        foreach($pjNameList as $pjName){
            $m = array();
            foreach($monthList as $month) {
                $m[$month] = 0;
            }
            $eachProjectEachMonth[$pjName] = $m;
        }

        return $eachProjectEachMonth;
    }
}
