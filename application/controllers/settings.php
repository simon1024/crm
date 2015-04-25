<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('dict_model');
        $this->load->model('employee_model');
        $this->load->model('project_model');
    }

    public function listPositions(){
        $title = "职位列表";
		$positionList = array();
		$deptList = $this->dict_model->getDeptList();
		$positionList = $this->dict_model->getPositionListWithDept();
        $data = array(
                    'positionList' => $positionList,
                    'deptList' => $deptList,
                    'deptList2' => $deptList,
					'title' => $title,
                    );
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('settings/listPositions', $data);
        $this->load->view('templates/footer');
    }

    public function listDepartments(){
        $title = "部门列表";
		$deptList = array();
		$deptList = $this->dict_model->getDeptListWithApprover();
        $employeeList = $this->employee_model->getListBaseInfo(array(),0,10000);
        $data = array(
                    'deptList' => $deptList,
                    'employeeList' => $employeeList,
					'title' => $title,
                    );
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('settings/listDepartments', $data);
        $this->load->view('templates/footer');
    }

    public function addDepartment(){
		$deptName = $this->input->post('dept_name');
		$deptApprover = $this->input->post('dept_approver');
        $user = $this->getSessionUserInfo();
        $this->dict_model->addDict('DeptType', array('name'=>$deptName));
		$deptId = $this->dict_model->getIdByName('DeptType', $deptName);
		$ohTaskName = 'OH-' . $deptName;
		$lvTaskName = 'LV-' . $deptName;
        $this->dict_model->addDict('TaskType', array('name'=>$ohTaskName, 'parent_id'=>0, 'oh_dept'=>$deptId['id']));
        $this->dict_model->addDict('TaskType', array('name'=>$lvTaskName, 'parent_id'=>0, 'oh_dept'=>$deptId['id']));

		$data = array(
						'name'=>'OVERHEAD',
						'project_status'=>5,
						'owner'=>$deptApprover,
						'pm'=>$deptApprover,
						'hours'=>2147483647,
						'oh_dept'=>$deptId['id'],
						'price'=>0
					);
        $this->addProject($data);

		exit;
    }

    public function addPosition(){
		$name = $this->input->post('name');
		$department = $this->input->post('department');
        $user = $this->getSessionUserInfo();
        $result = $this->dict_model->addDict('PositionType', array('name'=>$name, 'department'=>$department));

		echo json_encode($result);
		exit;
    }

    public function addProject($model){
		$model['total_price'] = $model['price'];
		// 检查用户名合法性.
		$ownerId = $this->employee_model->getIdByUserName($model['owner']);
		$pmId = $this->employee_model->getIdByUserName($model['pm']);
		$dmId = 0;
		if($ownerId < 1){
			$result = array('status'=>'no', 'msg'=>"{$model['owner']} 该用户名不存在");
			echo json_encode($result);
			exit;
		}
		if($pmId < 1){
			$result = array('status'=>'no', 'msg'=>"{$model['pm']} 该用户名不存在");
			echo json_encode($result);
			exit;
		}
		if(!empty($model['dm'])){
			$dmId = $this->employee_model->getIdByUserName($model['dm']);
			if($dmId < 1){
				$result = array('status'=>'no', 'msg'=>"{$model['dm']} 该用户名不存在");
				echo json_encode($result);
				exit;
			}
		}
		$model['owner'] = $ownerId;
		$model['pm'] = $pmId;
		$model['dm'] = $dmId;
		$model['type'] = 8;
		$model['name']='OVERHEAD';
		$no = $this->project_model->generateUniqNo();
		$model['no']=$no;
		$result = $this->project_model->add($model);

		$no = $this->project_model->generateUniqNo();
		$model['no']=$no;
		$model['name']='LEAVE';
		$model['type'] = 9;
		$result = $this->project_model->add($model);

		echo json_encode($result);
		exit;
	}

    public function updateDepartment(){
        $id = intval($this->uri->segment(3));
        $uid = $this->getSessionUid();
        $array = array(
                        'dept_name'=>'name', 
						'dept_approver'=>'pm'
                    );
        $model = $this->formDataToModel($array, 'post');
        $model['id'] = $id;

        $dbModel = $this->dict_model->getDeptById($id);
        if(empty($dbModel)){
            $array = array('status'=>'no', 'msg'=>'id错误。');
            echo json_encode($array);
            exit;
        }

		$pmId = $this->employee_model->getIdByUserName($model['pm']);
		if($pmId < 1){
			$result = array('status'=>'no', 'msg'=>"{$model['pm']} 该用户名不存在");
			echo json_encode($result);
			exit;
		}

        $array = $this->project_model->updateByDept($id, $pmId);
        $array = $this->dict_model->updateTaskTypeByPid($id, $model['name']);
        $array = $this->dict_model->updateById('DeptType', $id, array('id'=>$id, 'name'=>$model['name']));
        echo json_encode($array);
        exit;
    }

    public function updatePosition(){
        $id = intval($this->uri->segment(3));
        $uid = $this->getSessionUid();

        $array = array(
                        'position_name'=>'name', 
						'department'=>'department'
                    );
        $model = $this->formDataToModel($array, 'post');
        $model['id'] = $id;

        $array = $this->dict_model->updateById('PositionType', $id, array('department'=>$model['department'], 'name'=>$model['name']));

        echo json_encode($array);
        exit;
    }

    public function delDepartment(){
        $id = intval($this->uri->segment(3));
        $uid = $this->getSessionUid();

        $dbModel = $this->dict_model->getDeptById($id);
        if(empty($dbModel)){
            $array = array('status'=>'no', 'msg'=>'id错误。');
            echo json_encode($array);
            exit;
        }
        // delete .
        $array = $this->dict_model->delTaskTypeByPid($id);
        $array = $this->dict_model->delDeptById($id);
		$dept = $id;
		$array = $this->project_model->delByDept($dept);
        echo json_encode($array);
        exit;
    }

    public function delPosition(){
        $id = intval($this->uri->segment(3));
        $uid = $this->getSessionUid();

        // delete .
        $array = $this->dict_model->delPositionById($id);
        echo json_encode($array);
        exit;
    }
}
