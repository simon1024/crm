<?php

class Task_model extends CI_Model {

    private $table = 'Task';

    public function __construct(){
        $this->load->database();
        $this->config->load('myconfig');
    }


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

    function updateById($model){
		$data = array(
			   'hour' => $model['hour'],
			   'start_time' => $model['start_time'],
			   'end_time' => $model['end_time']
			);

		$this->db->where('id', $model['id']);
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

    function getTaskByPids($projectList){
        $array = array();
        foreach($projectList as $project){
            $pid = $project['id'];
            $tasks = $this->getAllTaskByProjectId($pid, true);
            $array[$pid] = $tasks;
        }
        return $array;
    }

    function getAllTaskByProjectId($pid, $forTimeSheet=false){
        $pid = intval($pid);
        //$sql = "select * from Task where project_id=$pid and  parent_id=0 and status=3; ";
        $sql = "select a.id as id,project_id,b.id as tid, b.name as taskName,c.id as subTaskId,c.name as subTaskName,a.name as parent_id,a.status,a.addTime,a.end_time,hour,a.start_time ,p.oh_dept,p.name as pName
		from Task a 
		left join TaskType b on a.name=b.id 
		left join TaskType c on a.subName=c.id 
        left join Project p on a.project_id=p.id
		where project_id=$pid and a.status=3  and p.status=3
		order by a.name asc, a.start_time asc";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $parentId = $row['parent_id'];
            //$parentId = $row['tid'];
            $id = $row['id'];
            if($row['oh_dept']>0 && $forTimeSheet){
                $row['taskName'] = $row['pName'];
                $row['subTaskName'] = $row['pName'];
                //@todo
                $row['subTaskId'] = '0';
                $data[$parentId]['subTask'] = array();
                $data[$parentId]['subTask'][] = $row;
                continue;
            }
            if($parentId == 0){
                $data[$id] = $row;
            }else{
                $data[$parentId]['subTask'][] = $row;
            }
        }
        return $data;
    }


    function getBasicInfoById($id){/*{{{*/
        $id = intval($id);
        $sql = "select p.id,p.no,p.name as name,p.type as project_type, p.project_status, e.name as pmName, d.name as dmName, o.name as ownerName,  p.progress, DATE_FORMAT(p.ex_endTime, '%Y-%m-%d') as ex_endTime, DATE_FORMAT(p.startTime, '%Y-%m-%d') as startTime, DATE_FORMAT(p.endTime, '%Y-%m-%d') as endTime
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


    }/*}}}*/
    

    function getCount($filter=array()){/*{{{*/

        $filterStr = '';
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

        if(array_key_exists('name', $filter)){
            $value = $filter['name'];
            $sql = "select count(*) as count from Project p where p.status=3 $filterStr ;";
            $query = $this->db->query($sql); 
            $data = array();
            foreach ($query->result_array() as $row){
                return $row['count'];
            }
        }
        return $this->db->count_all($this->table);

    }/*}}}*/


    function getOHTaskByUser($user){
        $dept = intval($user['department']);
        $sql = " select * from TaskType where oh_dept=$dept and name like 'OH%'; ";
        $row = $this->getSingleResultBySql($sql);
		$query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }

		return $data;
    }

    function getLeaveTaskByUser($user){
        $dept = intval($user['department']);
        $sql = " select * from TaskType where oh_dept=$dept and name like 'LV%'; ";
        $row = $this->getSingleResultBySql($sql);
        //echo json_encode($row);
        //exit;
		$query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }

		return $data;
        //$result[] = $row;
        //return array($row);
    }



    function del($id){
        $id = intval($id);
        $sql = "update Task set status=9 where id=$id or parent_id=$id;";
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

    function getById($id){
        $id = intval($id);
        $query = $this->db->get_where($this->table, array('id' => $id), 1, 0);
        $data = array();
        foreach ($query->result_array() as $row){
            return $row;
        }
        return array();
    }

	//获得某个项目指定子任务的数目
    function getExactCount($filter=array()){

        $filterStr = '';
        if(array_key_exists('name', $filter) && !empty($filter['name'])){
            $value = $filter['name'];
            $filterStr .= " and name='$value'";
        }
        if(array_key_exists('subName', $filter) && !empty($filter['subName'])){
            $value = $filter['subName'];
            $filterStr .= " and subName='$value' ";
        }
        if(array_key_exists('project_id', $filter) && $filter['project_id']>0){
            $value = $filter['project_id'];
            $filterStr .= " and project_id = $value ";
        }

        if(array_key_exists('name', $filter)){
            $value = $filter['name'];
            $sql = "select count(*) as count from Task where status=3 $filterStr ;";
            $query = $this->db->query($sql); 
            $data = array();
            foreach ($query->result_array() as $row){
                return $row['count'];
            }
        }
        return 0;

    }

	//获得某个项目已划分子任务的工时总和
    function getCurrentHoursByPid($projectId){

		$sql = "select sum(hour) as currentHours from Task where status=3 and project_id=$projectId ;";
		$query = $this->db->query($sql); 
		foreach ($query->result_array() as $row){
			return $row['currentHours'];
		}
		
		return 0;
    }
}
