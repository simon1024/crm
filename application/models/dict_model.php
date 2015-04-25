<?php

class Dict_model extends CI_Model {

    public function __construct(){
        $this->load->database();
        $this->config->load('myconfig');
    }

    public function getDictList($tableName, $sort='asc'){
        $this->db->order_by("id", $sort);
        $query = $this->db->get($tableName, 100, 0);
        $result = array();
        foreach($query->result_array() as $row){
            $result[] = $row;
        }
        return $result;
    }

    public function addDict($tableName, $data){
		/*
		if ($tableName=='TaskType')
			show_error(implode(',', $data));
		*/
        $success = $this->db->insert($tableName, $data); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';
        if($errno != 0){
            $status = 'no';
            $message = "添加失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

    public function del($tableName, $id){
        $dictTables = $this->config->item('dict_tables');
        if(in_array($tableName, $dictTables)){
            return $this->db->delete($tableName, array('id' => $id));
        }
        return false;
    }

    function getPositionByDepartments($departmentList){
        $array = array();
        foreach($departmentList as $department){
            $departmentId = $department['id'];
            $positions = $this->getAllPositionByDepartmentId($departmentId);
            $array[$departmentId] = $positions;
        }
        return $array;
    }

    function getAllPositionByDepartmentId($departmentId){
        $departmentId = intval($departmentId);
        //$sql = "select * from Task where project_id=$pid and  parent_id=0 and status=3; ";
        $sql = "select * from PositionType where department=$departmentId order by department asc";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            //$departmentId = $row['department'];
			$data[] = $row;
        }
        return $data;
    }

    function getSubTaskType($parentId){
        $parentId = intval($parentId);
        $sql = "select * from TaskType where parent_Id=$parentId order by id asc";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
			$data[] = $row;
        }
        return $data;
    }

    function getSubtaskTypeByParentId($subTaskType1List){
        $array = array();
        foreach($subTaskType1List as $taskType){
            $parentId = $taskType['id'];
            $taskTypes = $this->getSubTaskType($parentId);
            $array[$parentId] = $taskTypes;
        }
        return $array;
    }

    function getDeptById($id){
        $id = intval($id);
        $sql = "select * from DeptType where id=$id";
        $query = $this->db->query($sql); 
        foreach ($query->result_array() as $row){
			return $row;
        }
        return array();
    }

    function delDeptById($id){
		$id = intval($id);
        $success = $this->db->delete('DeptType', array('id'=>$id) ); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';

        if($errno != 0){
            $status = 'no';
            $message = "删除失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

    function delPositionById($id){
		$id = intval($id);
        $success = $this->db->delete('PositionType', array('id'=>$id) ); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';

        if($errno != 0){
            $status = 'no';
            $message = "删除失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

    function updateById($tableName, $id, $model){
		$id = intval($id);
		$this->db->where('id', $id);
		$this->db->update($tableName, $model); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';

        if($errno != 0){
            $status = 'no';
            $message = "更新失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

    function getIdByName($tableName, $name){
        $sql = "select id from $tableName where name='$name'";
        $query = $this->db->query($sql); 
        foreach ($query->result_array() as $row){
			return $row;
        }
        return array();
    }

    function updateTaskTypeByPid($id, $name){
		$id = intval($id);
    	$deptInfo = $this->getDeptById($id);
		$oldDeptName = $deptInfo['name'];
		$oldOhTaskName = 'OH-' . $oldDeptName;
		$oldLvTaskName = 'LV-' . $oldDeptName;
		$ohTaskName = 'OH-' . $name;
		$lvTaskName = 'LV-' . $name;

		$this->db->where('name', $oldOhTaskName);
		$this->db->update('TaskType', array('name'=>$ohTaskName)); 

		$this->db->where('name', $oldLvTaskName);
		$this->db->update('TaskType', array('name'=>$lvTaskName)); 

        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';

        if($errno != 0){
            $status = 'no';
            $message = "更新失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

    function delTaskTypeByPid($id){
		$id = intval($id);
    	$deptInfo = $this->getDeptById($id);
		$deptName = $deptInfo['name'];
		$ohTaskName = 'OH-' . $deptName;
		$lvTaskName = 'LV-' . $deptName;

        $success = $this->db->delete('TaskType', array('name'=>$ohTaskName) ); 
        $success = $this->db->delete('TaskType', array('name'=>$lvTaskName) ); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';

        if($errno != 0){
            $status = 'no';
            $message = "删除失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

    public function getDeptListWithApprover($sort='asc'){
        $this->db->order_by("id", $sort);

        $sql = "select d.id, d.name as dname, e.username as ename
				from DeptType d
				left join Project p on d.id=p.oh_dept and p.type=8
				left join Employee e on p.pm=e.id";
        $query = $this->db->query($sql); 

        $result = array();
        foreach($query->result_array() as $row){
            $result[] = $row;
        }
        return $result;
    }

    public function getPositionListWithDept(){
        $sql = "select p.id as pid, p.name as pname, d.id as did, d.name as dname
				from PositionType p
				left join DeptType d on p.department=d.id
                order by did";
        //show_error($sql);
        $query = $this->db->query($sql); 

        $result = array();
        foreach($query->result_array() as $row){
            $result[] = $row;
        }
        return $result;
    }

    public function getDeptList($sort='asc'){
        $this->db->order_by("id", $sort);

        $sql = "select d.id, d.name from DeptType d";
        $query = $this->db->query($sql); 

        $result = array();
        foreach($query->result_array() as $row){
            $result[] = $row;
        }
        return $result;
    }

    function getCategoryByFamily($familyList){
        $array = array();
        foreach($familyList as $family){
            $familyId = $family['id'];
            $familyName = $family['fname'];
            $categorys = $this->getAllCategoryByFamilyName($familyName);
            $array[$familyId] = $categorys;
        }
        return $array;
    }

    function getAllCategoryByFamilyName($familyName){
        //$sql = "select * from Task where project_id=$pid and  parent_id=0 and status=3; ";
        $sql = "select * from Category where fname='$familyName'";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
			$data[] = $row;
        }
        return $data;
    }
}
