<?php

class Project_model extends CI_Model {

    private $table = 'Project';

    public function __construct(){
        $this->load->database();
        $this->config->load('myconfig');
    }

    function checkNoExists($no){
        $query = $this->db->get_where($this->table, array('no' => $no), 1, 0);
        return $query->num_rows()>0? true: false;
    }

    function updateBasic($id, $data){
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

    function add($data){

        $exists = $this->checkNoExists($data['no']);
        if($exists){
            return array('status'=>'no', 'msg'=>'项目编号已经存在');
        }

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

    private function genFilterSql($filter){
        //
        $user = $filter['user'];
        $action = $filter['action'];
        $role = $user['role'];
        $uid = $user['id'];

        // filter user.
        $filterStr = '';
        // 如果是更新,副总，it, 一级审批人，二级审批人，负责人有权限.
        // 如果是更新,超级管理员,市场管理员，经理管理员有权限.
        //if($action == 'list_update'){
        //    if($role == 0 || $role>4 ){
        //        $filterStr .= " and (p.owner=$uid or p.pm=$uid or p.dm=$uid) ";
        //    }
        //}
        if($user['role'] != '1' && $user['role']!= 2){
            $filterStr .= " and p.oh_dept=0 ";
        }
        if(array_key_exists('no', $filter) && !empty($filter['no'])){
            $value = $filter['no'];
            $filterStr .= " and p.no='$value'";
        }
        if(array_key_exists('name', $filter) && !empty($filter['name'])){
            $value = $filter['name'];
            $filterStr .= " and p.name like '%$value%'";
        }
        if(array_key_exists('pstatus', $filter) && $filter['pstatus']>0){
            $value = $filter['pstatus'];
            $filterStr .= " and p.project_status = $value ";
        }
        if(array_key_exists('type', $filter) && $filter['type']>0){
            $value = $filter['type'];
            $filterStr .= " and p.type = $value ";
        }
        if(array_key_exists('timeRange', $filter) && !empty($filter['timeRange'])){
            list($rangeStart, $rangeEnd) = explode('~', $filter['timeRange']);
            $value = $filter['type'];
            $filterStr .= " and ((p.startTime>='$rangeStart' and p.startTime<='$rangeEnd')  or  (p.endTime>='$rangeStart' and p.endTime<='$rangeEnd') ) ";
        }
        return $filterStr;
    }

    function getAllProjectByUid($filter, $offset=0, $limit=20){/*{{{*/
        $offset = intval($offset);
        $limit = intval($limit);
        $filterStr = $this->genFilterSql($filter);

        $sql = "select p.id,p.no,p.name as name,  pt.name as typeName,  e.name as pmName, p.progress, pst.name as statusName,  DATE_FORMAT(p.ex_endTime, '%Y-%m-%d') as ex_endTime, DATE_FORMAT(p.startTime, '%Y-%m-%d') as startTime, DATE_FORMAT(p.endTime, '%Y-%m-%d') as endTime
        from Project p
        left join ProjectType pt on p.type=pt.id
        left join ProjectStatusType  pst on p.project_status=pst.id
        left join Employee e on e.id = p.pm
        where  p.status='3' $filterStr limit $offset , $limit;";

        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }
        return $data;
    }/*}}}*/

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

    function getTimeSheetProjectListByUid($uid){
		/*
        $sql = "select p.id,p.no,p.name 
        from Project p
        where  p.status='3' and oh_dept=0  limit 0,100";
		*/
        $sql = "select p.id,p.no,p.name 
        from Project p
        where  p.status='3' 
        and type not in (8,9)  
        and project_status not in (3, 7, 8)
        limit 0,1000";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }
        return $data;
    }

    function getOHProjectListByUid($user){
        // get user dept.
        $uid = intval($user['id']);
        $dept = intval($user['department']);
        $sql = "select p.id,p.no,p.name 
        from Project p
        where  p.status='3' and oh_dept=$dept and p.type=8";
		//show_error($sql);
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }
        return $data;
    }

    function getLeaveProjectListByUid($user){
        // get user dept.
        $uid = intval($user['id']);
        $dept = intval($user['department']);
        $sql = "select p.id,p.no,p.name 
        from Project p
        where  p.status='3' and oh_dept=$dept and p.type=9";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }
        return $data;
    }

    function getBasicInfoById($id){
        $id = intval($id);
        $sql = "select p.id,p.no,p.name as name,p.type as project_type, p.price,p.total_price, p.project_status, p.hours as hours,  e.name as pmName, e.username as pmUserName, d.name as dmName, d.username as dmUserName, o.name as ownerName,o.username as ownerUserName,  p.progress, DATE_FORMAT(p.ex_endTime, '%Y-%m-%d') as ex_endTime, DATE_FORMAT(p.startTime, '%Y-%m-%d') as startTime, DATE_FORMAT(p.endTime, '%Y-%m-%d') as endTime
        from Project p
        left join Employee e on e.id = p.pm
        left join Employee d on d.id = p.dm
        left join Employee o on o.id = p.owner
        where p.id=$id
        ";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }
        return $data;


    }
    
    function getCount($filter=array()){/*{{{*/

        $filterStr = $this->genFilterSql($filter);
        $sql = "select count(*) as count from Project p where p.status=3 $filterStr ;";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            return $row['count'];
        }
        return 0;

    }/*}}}*/

    function getById($id){
        $id = intval($id);
        $query = $this->db->get_where($this->table, array('id' => $id), 1, 0);
        $data = array();
        foreach ($query->result_array() as $row){
            return $row;
        }
        return array();
    }

    function getByNo($no){
        $query = $this->db->get_where($this->table, array('no' => $no), 1, 0);
        $data = array();
        foreach ($query->result_array() as $row){
            return $row;
        }
        return array();
    }

    function getLimitHoursByPid($id){
        $project = $this->getById($id);
        if(!$project){
            return 0;
        }
        return $project['hours'];
    }

	/*
	// old function, just set status 9 for del opertion
    function delById($id){
        $id = intval($id);
        $data = array('status'=>'9');
        $this->db->where('id', $id);
        $success = $this->db->update($this->table, $data); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';
        if($errno != 0){
            $status = 'no';
            $message = "删除失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }
	*/

    function delById($id){
        $id = intval($id);
        $data = array('id'=>$id);
        $success = $this->db->delete($this->table, $data); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';
        if($errno != 0){
            $status = 'no';
            $message = "删除失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

	// only del oh and lv project of the dept
    function delByDept($dept){
        $sql = "delete  from Project where oh_dept=$dept and type in (8,9)";
        $query = $this->db->query($sql); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';
        if($errno != 0){
            $status = 'no';
            $message = "删除失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

    function getApproveProjectList($uid){
        $uid = intval($uid);
        // get project list.
        $sql = "select *  from Project where pm=$uid or dm=$uid and status=3";
        $query = $this->db->query($sql); 
        $projectList = array();
        foreach ($query->result_array() as $row){
            $projectList[] = $row;
        }
        return $projectList;
    }


    function addHours($data){
        $success = $this->db->insert('Project_Hours', $data); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';
        $pid = $data['pid'];
        $hours = $data['hours'];

        if($errno != 0){
            $status = 'no';
            $message = "添加失败，错误代码 $errno ";
        }else{
            $sql = "update Project set hours=(hours+{$hours}) where id=$pid ";
            $query = $this->db->query($sql); 
            $message = '追加记录成功';
            // @todo process .$errno = $this->db->_error_number();
        }
        return array('status'=>$status, 'msg'=>$message);
    }


    function getHoursListById($pid){
        $pid = intval($pid);
        $sql = "select e.name, e.username, p.hours, p.reason,p.addTime  from Project_Hours p left join Employee e on e.id=p.add_uid where p.pid=$pid";
        return $this->getResultBySql($sql);
    }


    function appendPrice($data){
        $success = $this->db->insert('Project_Price_History', $data); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';
        if($errno != 0){
            $status = 'no';
            $message = "添加失败，错误代码 $errno ";
        }else{
            // update project total price
            $pid = $data['pid'];
            $price = $data['price'];
            $sql = "update Project set total_price=(total_price+({$data['price']})) where id=$pid ";
            $query = $this->db->query($sql); 
            $message = '追加金额成功';
        }
        return array('status'=>$status, 'msg'=>$message);
    }

    function getAllPriceHistory($pid){/*{{{*/
        $pid = intval($pid);
        $sql = "select p.id, p.price,p.desc,e.name as employeeName,p.addTime  from Project_Price_History p left join Employee e on e.id=p.add_uid  where pid=$pid and p.status=3 ";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $id = $row['id'];
            $data[$id] = $row;
        }
        return $data;
    }/*}}}*/

	private function generateRandomString($length = 10) {
		$characters = '0123456789';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

    public function generateUniqNo() {
		while(1) {
			$no = $this->generateRandomString(6);
			$data = $this->getByNo($no);
			if(empty($data))
				return $no;
		}
	}

	//only update oh and lv project of the dept
    function updateByDept($id, $pm){
        $this->db->where('oh_dept', $id);
        //$success = $this->db->update($this->table, array('pm'=>$pm)); 
		$sql = "update Project set pm=$pm where oh_dept=$id and type in (8,9)";
		$query = $this->db->query($sql); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';

        if($errno != 0){
            $status = 'no';
            $message = "更新失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

    function getAutoCompleteProjectList(){
        $sql = "select p.no,p.name 
        from Project p
        limit 0,1000";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }
        return $data;
    }

}
