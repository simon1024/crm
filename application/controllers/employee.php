<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('employee_model');
        $this->load->model('dict_model');
    }

    public function view($slug){
        $this->load->view('templates/header', $data);
        $this->load->view('stats/view', $data);
        $this->load->view('templates/footer');
    }


    private function toAddEmployee(){
        $data = array();
        $deptList = $this->dict_model->getDictList('DeptType');
        $posList = $this->dict_model->getDictList('PositionType');
        $roleList = $this->dict_model->getDictList('RoleType', 'desc');
        // get all employee list.
        $employeeList = $this->employee_model->getListBaseInfo(array(),0,10000);
        $positionsOfDept = $this->dict_model->getPositionByDepartments($deptList);

        $data = array(
                    'deptList' => $deptList,
                    'posList' => $posList,
                    'roleList' => $roleList,
                    'employeeList' => $employeeList,
					'positionsOfDept' => $positionsOfDept,
                    );
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('employee/add', $data);
        //$this->load->view('employee/add', $data);
        $this->load->view('templates/footer');
    }

    public function listAll(){
        $data = array();
        $filter = array();
        // pagination .
        $pageSize = 20;
        $currentPage = $this->uri->segment(3)>0? $this->uri->segment(3) : 1;
        $queryKwd = $this->uri->segment(5);
        $offset = ($currentPage-1) * $pageSize; 
        // filter
        if(!empty($queryKwd)){
            if (is_numeric($queryKwd))
                {
                    $filter['department'] = $queryKwd;
                }
            else
            	$filter['name'] = urldecode($queryKwd);
        }
        // pagination.
        $this->load->library('pagination');
        $config = $this->getBasePaginationConfig();
        $this->load->helper('url');
        $config['base_url'] = base_url() . '/employee/listAll';
        //$config['base_url'] = current_url();
        $totalCount = $this->employee_model->getCount($filter);
        $config['total_rows'] = $totalCount;
        $config['per_page'] = $pageSize; 
        $config['reuse_query_string'] = TRUE;
        $config['suffix'] = "/s/$queryKwd"; 
        $config['first_url'] = $config['base_url'] .'/1/' . $config['suffix'];
        //var_dump($config['suffix']);
        //exit;
        $this->pagination->initialize($config); 
        //var_dump($this->pagination->create_links());
        //exit;
        $data['total'] = $totalCount;
        $data['employeeList'] = $this->employee_model->getListBaseInfo($filter,$offset, $pageSize);
        $data['deptList'] = $this->dict_model->getDictList('DeptType');
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('employee/list', $data);
        $this->load->view('templates/footer');
    }

    /** Add employee **/ 
    public function add(){
        //var_dump($this->getSessionUserInfo());
        $method = $this->getMethod();
        if($method == 'GET'){
            $this->toAddEmployee();
        }else{
            $array = array(
                            'no',      
                            'name',      
                            'username',
                            'password'=>'pwd',
                            'gender',
                            'position',
                            'department',
                            'leader',
                            'tel',
                            'mobile',
                            'birthday',
                            'joinDate',
                            'role'
                        );
            $model = $this->formDataToModel($array, 'post');
            // get parameters from form.
            $result = $this->employee_model->add($model);
            //$result = array('status'=>'ok',msg=>'00');
            echo json_encode($result);
            
            exit;
        }

    }
    
    private function toUpdateEmployee(){
        // get baisc info.
        $id = intval($this->uri->segment(3));
        $basicInfo = $this->employee_model->getBasicInfoById($id);

        $data = array();
        $departmentTypeList = $this->dict_model->getDictList('DeptType');
        $positionTypeList = $this->dict_model->getDictList('PositionType');
        $roleTypeList = $this->dict_model->getDictList('RoleType');
        $employeeList = $this->employee_model->getListBaseInfo(array(),0,10000);
        $positionsOfDept = $this->dict_model->getPositionByDepartments($departmentTypeList);

        $data = array(
                    'deptList' => $departmentTypeList,
                    'posList' => $positionTypeList,
                    'roleList' => $roleTypeList,
                    'basicInfo' => $basicInfo,
                    'employeeList' => $employeeList,
					'positionsOfDept' => $positionsOfDept,
                    );
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('employee/update', $data);
        $this->load->view('templates/footer');
    }

    function updateBasic(){
        $id = $this->input->post('eid');
        $array = array(
						'no',
						'name',
						'username',
						'gender',
						'position',
						'department',
						'leader',
						'mail',
						'tel',
						'mobile',
						'birthday',
						'joinDate',
						'role'
                    );
        $model = $this->formDataToModel($array, 'post');
        $leaderId = $this->employee_model->getIdByUserName($model['leader']);
        if($leaderId < 1 and $model['leader']!=""){
            $result = array('status'=>'no', 'msg'=>"{$model['leader']} 该用户名不存在");
            echo json_encode($result);
            exit;
        }
        $model['leader'] = $leaderId;
        $result = $this->employee_model->updateBasic($id, $model);
        echo json_encode($result);
        exit;
    }

    function updatePersonalInfo(){
        $id = $this->input->post('eid');
        $array = array(
						'name',
						'gender',
						'tel',
						'mobile',
						'birthday',
						'joinDate',
                    );
        $model = $this->formDataToModel($array, 'post');
        $result = $this->employee_model->updateBasic($id, $model);
        echo json_encode($result);
        exit;
    }

    /**
     * @Desc: 更新员工信息.
     * @parameter: 
     **/
    public function update(){
        $method = $this->getMethod();
        if($method == 'GET'){
            $this->toUpdateEmployee();
        }else{
            $id = intval($this->uri->segment(3));
            $array = array(
                            'no',
                            'name',
							'username',
                            'gender',
                            'position',
                            'department',
                            'leader',
                            'tel',
                            'mobile',
                            'birthday',
                            'joinDate',
                            'status',
                            'role'
                        );
            $model = $this->formDataToModel($array, 'post');
            $result = $this->employee_model->update($id, $model);
            echo json_encode($result);
            exit;
        }
    }

    /**
     * @Desc: 检查用户名是否存在.
     * @parameter: username.
     **/
    public function exits(){
        $userName = $this->input->get('username');
        $exits = $this->employee_model->checkUserNameExists($userName);
        var_dump($exits);
        exit;
    }

     /**
     * @Desc: 更新用户状态
     * @parameter: .
     **/
    public function updateStatus(){
        $uid = $this->input->post('uid');
        $status = $this->input->post('status');
        $data = array('status'=>$status);
        $success = $this->employee_model->updateStatus($uid, $data);
        var_dump($success);
    }

    // 删除员工: 只有人事管理员 & 超级管理人员有权限操作.
    public function del(){
        $eid = $this->input->post('id');
        $eid = intval($eid);
        //
        $user = $this->getSessionUserInfo();
        $roleId = $user['role'];
        if($roleId !=1 &&  $roleId !=2){
            $result = array('status'=>'no', 'msg'=>'权限不足，只有it人员有删除员工权限。');
            echo json_encode($result);
            exit;
        }
        $result = $this->employee_model->delById($eid);
        echo json_encode($result);
        exit;
    }

	public function checkCurrentPasswd() {
        //$eid = $this->input->post('eid');
		$eid = $this->getSessionUid();
        $eid = intval($eid);
        $pwd = $this->input->post('current_passwd');
        //
        $result = $this->employee_model->checkCurrentPasswd($eid, $pwd);
        echo json_encode($result);
        exit;
	}

    private function toSetPwd(){
        $this->load->view('templates/header');
        $this->load->view('employee/setpwd');
        $this->load->view('templates/footer');
    }

    /** set passwd **/ 
    public function setpwd(){
        //var_dump($this->getSessionUserInfo());
        $method = $this->getMethod();
        if($method == 'GET'){
            $this->toSetPwd();
        }else{
            //$id = intval($this->uri->segment(3));
			$id = $this->getSessionUid();
            $array = array('new_passwd'=>'pwd');
            $model = $this->formDataToModel($array, 'post');
            // get parameters from form.
            $result = $this->employee_model->updatePwd($id, $model);
            echo json_encode($result);
            exit;
        }
	}

	/** view self info **/
    public function personal(){
        //var_dump($this->getSessionUserInfo());
		$id = $this->getSessionUid();
		//$id = intval($this->uri->segment(3));
        $basicInfo = $this->employee_model->getPersonalInfoById($id);

		if ($basicInfo[0]['gender'] == '1')
			$basicInfo[0]['genderName'] = '男';
		else
			$basicInfo[0]['genderName'] ='女';
	
        $data = array('basicInfo' => $basicInfo,);
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('employee/personal', $data);
        //$this->load->view('employee/personal');
        $this->load->view('templates/footer');
	}

	/** view detail info **/
    public function viewDetail(){
		//$id = $this->getSessionUid();
		$id = intval($this->uri->segment(3));
        $basicInfo = $this->employee_model->getPersonalInfoById($id);
        $data = array('basicInfo' => $basicInfo,);
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('employee/view', $data);
        //$this->load->view('employee/view');
        $this->load->view('templates/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
