<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('project_model');
        $this->load->model('task_model');
        $this->load->model('dict_model');
        $this->load->model('employee_model');
        $this->load->model('bill_model');
    }

    private function loadProjectTemplate($action){
        // get baisc info.
        $id = intval($this->uri->segment(3));
        $basicInfo = $this->project_model->getBasicInfoById($id);
        // 拆分任务.
        $taskList = $this->task_model->getAllTaskByProjectId($id);
        // 付款节点
        $billList = $this->bill_model->getAllBillByProjectId($id);
        // 追加记录
        $appendPriceHistory = $this->project_model->getAllPriceHistory($id);

        $data = array();
		$taskType1List = $this->dict_model->getSubTaskType(0);
		$taskType2List = $this->dict_model->getSubTaskTypeByParentId($taskType1List);
        $projectTypeList = $this->dict_model->getDictList('ProjectType');
        $projectStatusList = $this->dict_model->getDictList('ProjectStatusType');
        // employee list
        $employeeList = $this->employee_model->getListBaseInfo(array(),0,10000);
        // append hours list.
        $hoursList = $this->project_model->getHoursListById($id);

        $data = array(
					'taskType1List' => $taskType1List,
					'taskType2List' => $taskType2List,
                    'projectTypeList' => $projectTypeList,
                    'projectStatusList' => $projectStatusList,
                    'basicInfo' => $basicInfo,
                    'taskList' => $taskList,
                    'employeeList' => $employeeList,
                    'hoursList' => $hoursList,
                    'billList' => $billList,
                    'appendPriceHistory'=>$appendPriceHistory,
                    );
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('project/'.$action, $data);
        $this->load->view('templates/footer');

    }

    function view(){
        $this->loadProjectTemplate('view');
    }

    private function toUpdateProject(){
        $this->loadProjectTemplate('update');
    }


    private function checkPermissionByPid($id){
        // 检查权限。只有超级管理员 | 市场管理员| 经理管理员。
        $user = $this->getSessionUserInfo(); 
        $loginUid = $user['id'];
        $role = $user['role'];
        if( $role != 1 && $role!=3 && $role!=4 ){
            $result = array('status'=>'no', 'msg'=>"只有超级管理员，市场管理员，经理管理员有权限进行该操作");
            echo json_encode($result);
            exit;
        }
    }

    private function checkUnicity($projectId, $name, $subName){
        // 检查子任务是否重复。
		$filter = array('project_id'=>$projectId, 'name'=>$name, 'subName'=>$subName);
        $count = $this->task_model->getExactCount($filter);
        if( $count > 0 ){
            $result = array('status'=>'no', 'msg'=>"重复的工作内容");
            echo json_encode($result);
            exit;
        }
    }

    private function checkCurrentHours($hours, $projectId){
        // 检查子任务是否超时。
        $currentHours = $this->task_model->getCurrentHoursByPid($projectId);
        $maxHours = $this->project_model->getLimitHoursByPid($projectId);
        if( $currentHours+$hours > $maxHours ){
            $result = array('status'=>'no', 'msg'=>"子任务超时");
            echo json_encode($result);
            exit;
        }
    }

    function updateBasic(){
        $id = $this->input->post('pid');
        $array = array(
                        'no',
                        'name',
                        'type',
                        'project_status',
                        'addTime',
                        'startTime',
                        'endTime',
                        'ex_endTime',
                        'progress',
                        'owner',
                        'pm',
                        'dm'
                    );
        $model = $this->formDataToModel($array, 'post');
        $this->checkPermissionByPid($id);
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

        $result = $this->project_model->updateBasic($id, $model);
        echo json_encode($result);
        exit;
    }

    public function update(){
        $method = $this->getMethod();
        if($method == 'GET'){
            $this->toUpdateProject();
        }else{
            $id = intval($this->uri->segment(3));
            $array = array(
                            'no',
                            'name',
                            'type',
                            'project_status',
                            'owner',
                            'pm',
                            'dm',
                            'addTime',
                            'startTime',
                            'endTime',
                            'ex_endTime',
                            'progress'
                        );
            $model = $this->formDataToModel($array, 'post');
            $result = $this->project_model->update($id, $model);
            echo json_encode($result);
            exit;
        }
    }


    private function toAddProject(){/*{{{*/
        $data = array();
        $projectTypeList = $this->dict_model->getDictList('ProjectType');
        $projectStatusList = $this->dict_model->getDictList('ProjectStatusType');
        // get all employee list.
        $employeeList = $this->employee_model->getListBaseInfo(array(),0,10000);
        $data = array(
                    'projectTypeList' => $projectTypeList,
                    'projectStatusList' => $projectStatusList,
                    'employeeList' => $employeeList,
                    );
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('project/addBasic', $data);
        $this->load->view('templates/footer');
    }/*}}}*/


    // 创建项目基本信息
    public function add(){
        $method = $this->getMethod();
        if($method == 'GET'){
            $this->toAddProject();
        }else{
            $array = array(
                            'no',
                            'name',
                            'type',
                            'project_status',
                            'owner',
                            'pm',
                            'dm',
                            'addTime',
                            'startTime',
                            'endTime',
                            'ex_endTime',
                            'progress',
                            'hours',
                            'price',
                        );
            $model = $this->formDataToModel($array, 'post');
            $model['addTime'] = date('Y-m-d H:i:00');
            $this->addProject($model);
        }
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
		$result = $this->project_model->add($model);
		echo json_encode($result);
		exit;
	}

    private function updateBasicById($productId, $model){
        $result = $this->project_model->update($productId, $model);
    }

    // 修改项目负责人.
    public function updateProjectOwner(){
        $array = array('owner');
        $model = $this->formDataToModel($array, 'post');
        // get parameters from form.
        $productId = $this->input->post('pid');
        // @TODO check privileges
        $this->updateBasicById($productId, $model);
    }

    // 修改项目进度.
    public function updateProjectProgress(){
        $array = array('progress');
        $model = $this->formDataToModel($array, 'post');
        $productId = $this->input->post('pid');
        // @TODO check privileges
        $this->updateBasicById($productId, $model);
    }

    // 添加子任务.
    public function addTask(){
        $array = array(
                        'pid' => 'project_id', 
                        'name', 
                        'subName',
                        'parent_id',
                        'startTime' => 'start_time',
                        'endTime' => 'end_time',
                        'hour'
                    );
        $model = $this->formDataToModel($array, 'post');
        // @TODO check privileges: 检查该用户是否有修改项目的权利.
        $this->checkPermissionByPid($model['project_id']);
		// @TODO check unicity of subTask
		$this->checkUnicity($model['project_id'], $model['name'], $model['subName']);
		// @TODO check max hours of subTask
		$this->checkCurrentHours($model['hour'], $model['project_id']);
        $result = $this->task_model->add($model);
        echo json_encode($result);
        exit;
    }

    // 批量添加子任务.
    public function addBatchTask(){
        $array = array(
                        'pid' => 'project_id', 
                        'name', 
                        'subNames',
                        'parent_id',
                        'startTime' => 'start_time',
                        'endTime' => 'end_time',
                        'hour'
                    );
        $model = $this->formDataToModel($array, 'post');
		$subNameList = explode(",", $model['subNames']);
        // @TODO check privileges: 检查该用户是否有修改项目的权利.
        $this->checkPermissionByPid($model['project_id']);
		// @TODO check unicity of subTask
		foreach($subNameList as $subName){
			$this->checkUnicity($model['project_id'], $model['name'], $subName);
		}
		// @TODO check max hours of subTask
		$hours = ((int)$model['hour'])*count($subNameList);
		$this->checkCurrentHours($hours, $model['project_id']);

		foreach($subNameList as $subName){
			$data = array('project_id'=>$model['project_id'], 'name'=>$model['name'], 'subName'=>$subName, 'parent_id'=>0,'start_time'=>$model['start_time'], 'end_time'=>$model['end_time'], 'hour'=>$model['hour']);
        	$result = $this->task_model->add($data);
		}
        $result = array('status'=>'ok', 'msg'=>'');
        echo json_encode($result);
        exit;
    }

    // 拆分付款节点.
    public function addBill(){
        $array = array(
                        'pid' => 'pid', 
                        'startTime'=>'start_time', 
                        'price',
                        'desc',
                    );
        $model = $this->formDataToModel($array, 'post');
        $uid = $this->getSessionUid();
        $model['add_uid'] = $uid;
        $this->checkPermissionByPid($model['pid']);
        // @TODO check privileges: 检查该用户是否有修改项目的权利.
        $result = $this->bill_model->add($model);
        echo json_encode($result);
        exit;
    }

    // 删除付款节点.
    public function delBill(){
        $id = $this->input->post('id');
        // @TODO check privileges: 检查该用户是否有修改项目的权利.
        $bill = $this->bill_model->getById($id);
        if(!$bill || $bill['pid']<1){
            $result = array('status'=>'no', 'msg'=>'找不到关联项目');
            echo json_encode($result);
            exit;
        }
        $pid = $bill['pid'];
        $this->checkPermissionByPid($pid);
        $result = $this->bill_model->del($id);
        echo json_encode($result);
        exit;
    }


    // 更新子任务.
    public function updateTask(){
        $array = array(
                        'id',
						'hour',
                        'start_time',
                        'end_time'
                    );
        $model = $this->formDataToModel($array, 'post');
        $result = $this->task_model->updateById($model);
        echo json_encode($result);
        exit;
    }

    // 删除子任务.
    public function delTask(){
        $taskId = $this->input->post('task_id');
        // @TODO check privileges: 检查该用户是否有修改项目的权利.
        $task = $this->task_model->getById($taskId);
        if(!$task || $task['project_id']<1){
            $result = array('status'=>'no', 'msg'=>'找不到关联项目');
            echo json_encode($result);
            exit;
        }
        $pid = $task['project_id'];
        $this->checkPermissionByPid($pid);
        $result = $this->task_model->del($taskId);
        echo json_encode($result);
        exit;
    }


    private function listProject($action){
        $user = $this->getSessionUserInfo();
        $uid = $user['id'];
        // filter.
        $pageSize = 20;
        $currentPage = $this->uri->segment(3)>0? $this->uri->segment(3) : 1;
        $offset = ($currentPage-1) * $pageSize; 
        // get parameters.
        $no = urldecode($this->input->get('no'));
        $name = urldecode($this->input->get('name'));
        $pstatus = $this->input->get('pstatus');
        $type = $this->input->get('type');
        $timeRange = $this->input->get('range');
        $filter = array(
                    'no' => $no,
                    'name' => $name,
                    'pstatus' => $pstatus,
                    'type' => $type,
                    'timeRange' => $timeRange,
                    'user' => $user,
                    'action' => $action,
                  );
        // pagination.
        $this->load->library('pagination');
        $config = $this->getBasePaginationConfig();
        $this->load->helper('url');
        if ('list_update' == $action)
            $config['base_url'] = base_url() . '/project/listAll';
        else
            $config['base_url'] = base_url() . '/project/viewAll';
        //$config['base_url'] = current_url();
        $totalCount = $this->project_model->getCount($filter);
        $config['total_rows'] = $totalCount;

        $config['per_page'] = $pageSize; 
        $config['reuse_query_string'] = TRUE;
        $config['suffix'] = "?no=$no&name=$name&pstatus=$pstatus&type=$type&range=$timeRange"; 
        $config['first_url'] = $config['base_url'] .'/1/' . $config['suffix'];
        $this->pagination->initialize($config); 

        // get contents.
        $result = $this->project_model->getAllProjectByUid($filter, $offset, $pageSize);

        // load dict data
        $ptList = $this->dict_model->getDictList('ProjectType');
        $pstList = $this->dict_model->getDictList('ProjectStatusType');
        
        $pjList = $this->project_model->getAutoCompleteProjectList();

        $data = array(
                    'ptList' => $ptList,
                    'pstList' => $pstList,
					'search_no' => $no,
                    'search_name' => $name,
                    'search_status' => $pstatus,
                    'search_type' => $type,
                    'search_timeRange' => $timeRange,
                    'total' => $totalCount,
                    'pjList' => $pjList,
                    );

        $data['projectList'] = $result;
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('project/'.$action, $data);
        $this->load->view('templates/footer');
    }

    /**
     * Desc: 项目列表.
     * @parameter uid: 根据uid 进行过滤.
     */
    public function listAll(){
        $this->listProject('list_update');
    }

    public function viewAll(){
        $this->listProject('list_view');
    }


    /**
     * Desc: 项目列表.
     * @parameter uid: 根据uid 进行过滤.
     * @parameter filters: 其他过滤条件.
     */
    public function listByFilters(){
    }



    // 删除项目: 只有it人员 & 超级管理人员有权限操作.
    public function del(){
        $pid = $this->input->post('id');
        $pid = intval($pid);
        //
        $user = $this->getSessionUserInfo();
        $roleId = $user['role'];
        if($roleId !=1 &&  $roleId !=3 && $roleId !=4){
            $result = array('status'=>'no', 'msg'=>'权限不足，只有超级管理员、市场管理员、经理管理员有删除项目权限。');
            echo json_encode($result);
            exit;
        }
        $result = $this->project_model->delById($pid);
        echo json_encode($result);
        exit;
    }


    function appendTimes(){
        $array = array(
                        'pid',
                        'hours',
                        'reason'
                    );
        $model = $this->formDataToModel($array, 'post');
        $uid = $this->getSessionUid();
        $model['add_uid'] = $uid;
        $result = $this->project_model->addHours($model);
        echo json_encode($result);
        exit;
    }

    function appendPrice(){
        $array = array(
                        'pid',
                        'price',
                        'desc'
                    );
        $model = $this->formDataToModel($array, 'post');
        $this->checkPermissionByPid($model['pid']);
        $uid = $this->getSessionUid();
        $model['add_uid'] = $uid;
        $result = $this->project_model->appendPrice($model);
        echo json_encode($result);
        exit;
    }


}
