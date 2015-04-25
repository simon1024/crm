<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('supplier_model');
        $this->load->model('dict_model');
        $this->load->model('score_model');
    }

    private function loadSupplierTemplate($action){
        // get baisc info.
        $id = intval($this->uri->segment(3));
        $basicInfo = $this->supplier_model->getBasicInfoById($id);
        $companyType = $this->dict_model->getDictList('CompanyType');
        $family = $this->dict_model->getDictList('Family');
        $vendorProperty = $this->dict_model->getDictList('VendorProperty');
        $category = $this->dict_model->getDictList('Category');
        $categoryOfFamily = $this->dict_model->getCategoryByFamily($family);

        // 打分记录
        $comments = $this->score_model->getCommentsBySid($id);
        $commentNum = $this->score_model->getCount(array('sid'=>$id));
        $totalScore = $this->score_model->getTotalScore($id);

        $data = array(
                     'basicInfo' => $basicInfo,
                     'basicInfo2' => $basicInfo,
                     'companyTypeList' => $companyType,
                     'familyList' => $family,
                     'vendorPropertyList' => $vendorProperty,
                     'categoryList' => $category,
                     'categoryOfFamily' => $categoryOfFamily,
                     'comments' => $comments,
                     'commentNum' => $commentNum,
                     'totalScore' => $totalScore,
                    );

        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('supplier/'.$action, $data);
        $this->load->view('templates/footer');
    }

    private function toAddSupplier(){
        $data = array();
        $companyType = $this->dict_model->getDictList('CompanyType');
        $family = $this->dict_model->getDictList('Family');
        $vendorProperty = $this->dict_model->getDictList('VendorProperty');
        $category = $this->dict_model->getDictList('Category');
        $categoryOfFamily = $this->dict_model->getCategoryByFamily($family);
        $data = array(
                     'companyTypeList' => $companyType,
                     'familyList' => $family,
                     'vendorPropertyList' => $vendorProperty,
                     'categoryList' => $category,
                     'categoryOfFamily' => $categoryOfFamily,
                     );

        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('supplier/add', $data);
        $this->load->view('templates/footer');
    }

    public function listAll(){
        /* show_error("test listAll"); */
        $data = array();
        $filter = array();

        // pagination .
        $pageSize = 20;
        $currentPage = $this->uri->segment(3)>0? $this->uri->segment(3) : 1;
        $offset = ($currentPage-1) * $pageSize; 

        // filter
        $name = urldecode($this->input->get('name'));
        $product = urldecode($this->input->get('product'));
        $sno = $this->input->get('sno');
        $pname = $this->input->get('pname');
        $ptype = $this->input->get('ptype');
        $others = $this->input->get('others');

        $filter = array(
                    'sno' => $sno,
                    'name' => $name,
                    'product' => $product,
                    'pname' => $pname,
                    'ptype' => $ptype,
                    'others' => $others,
                  );

        // pagination.
        $this->load->library('pagination');
        $config = $this->getBasePaginationConfig();
        $this->load->helper('url');
        $config['base_url'] = base_url() . '/supplier/listAll';
        $totalCount = $this->supplier_model->getCount($filter);
        $config['total_rows'] = $totalCount;
        $config['per_page'] = $pageSize; 
        $config['reuse_query_string'] = TRUE;
        $config['suffix'] = "?sno=$sno&name=$name&product=$product&ptype=$ptype&pname=$pname&others=$others"; 
        $config['first_url'] = $config['base_url'] .'/1/' . $config['suffix'];
        //var_dump($config['suffix']);
        $this->pagination->initialize($config); 
        //var_dump($this->pagination->create_links());
        //exit;
        $data['total'] = $totalCount;
        $data['supplierList'] = $this->supplier_model->getListBaseInfo($filter,$offset, $pageSize);
        $data['companyTypeList'] = $this->dict_model->getDictList('CompanyType');
        $data['sno'] = $sno;
        $data['name'] = $name;
        $data['product'] = $product;
        $data['pname'] = $pname;
        $data['ptype'] = $ptype;
        $data['others'] = $others;
        //show_error(implode(',', array_keys($data['supplierList'][0])));
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('supplier/list', $data);
        $this->load->view('templates/footer');
    }

    public function export(){
        $data = array();
        $filter = array();

        // filter
        $name = urldecode($this->input->get('name'));
        $product = urldecode($this->input->get('product'));
        $sno = $this->input->get('sno');
        $pname = $this->input->get('pname');
        $ptype = $this->input->get('ptype');
        $others = $this->input->get('others');

        $filter = array(
                    'sno' => $sno,
                    'name' => $name,
                    'product' => $product,
                    'pname' => $pname,
                    'ptype' => $ptype,
                    'others' => $others,
                  );

        $supplierList = $this->supplier_model->exportByFilters($filter);
        $supplierList = iconv('utf-8', 'gbk', $supplierList);
        header("Content-Type: application/vnd.ms-excel; charset=gbk");
        $this->load->helper('download_helper');
        force_download('supplier.csv', $supplierList);
    }

    /** Add supplier **/ 
    public function add(){
        //var_dump($this->getSessionUserInfo());
        $method = $this->getMethod();
        if($method == 'GET'){
            $this->toAddSupplier();
        }else{
            $array = array(
                            'chName',      
                            'enName',      
                            'country',
                            'city',
                            'addr',
                            'zcode',
                            'foundDate',
                            'capital',
                            'staffNum',
                            'companyType',
                            'vendorProperty',
                            'service',
                            'family'=>'familyId',
                            'category'=>'categoryId',
                            'subCategory',
                            'website',
                            'contactor1',
                            'position1',
                            'telPhone1',
                            'cellPhone1',
                            'fax1',
                            'mail1',
                            'contactor2',
                            'position2',
                            'telPhone2',
                            'cellPhone2',
                            'fax2',
                            'mail2',
                            'qualification',
                        );
            $model = $this->formDataToModel($array, 'post');
            // get parameters from form.
            $result = $this->supplier_model->add($model);
            echo json_encode($result);
            exit;
        }

    }
    
    // 删除供应商: 只有supplier管理员 & 超级管理人员有权限操作.
    public function del(){
        $sid = $this->input->post('id');
        $sid = intval($sid);
        //
        $user = $this->getSessionUserInfo();
        $roleId = $user['role'];
        if($roleId !=1 &&  $roleId !=7){
            $result = array('status'=>'no', 'msg'=>'权限不足，只有supplier管理员 & 超级管理人员有权限操作.');
            echo json_encode($result);
            exit;
        }
        $result = $this->supplier_model->delById($sid);
        $result = $this->score_model->delBySupplierId($sid);
        echo json_encode($result);
        exit;
    }

    public function update(){
        $method = $this->getMethod();
        if($method == 'GET'){
            $this->toUpdateSupplier();
        }
    }

    function updateBasic(){
        $id = $this->input->post('sid');
        $array = array(
                       'chName',      
                       'enName',      
                       'country',
                       'city',
                       'addr',
                       'zcode',
                       'foundDate',
                       'capital',
                       'staffNum',
                       'companyType',
                       'vendorProperty',
                       'service',
                       'family'=>'familyId',
                       'category'=>'categoryId',
                       'subCategory',
                       'website',
                       'contactor1',
                       'position1',
                       'telPhone1',
                       'cellPhone1',
                       'fax1',
                       'mail1',
                       'contactor2',
                       'position2',
                       'telPhone2',
                       'cellPhone2',
                       'fax2',
                       'mail2',
                       'qualification',
                    );
        $model = $this->formDataToModel($array, 'post');
        //$this->checkPermissionBySid($id);

        $result = $this->supplier_model->update($id, $model);
        echo json_encode($result);
        exit;
    }

    function view(){
        $this->loadSupplierTemplate('view');
        /* $sid = $this->uri->segment(3); */
        /* $basicInfo = $this->supplier_model->getBasicInfoById($sid); */

        /* $data = array('sid'=>$sid, */
        /*              'basicInfo' => $basicInfo */
        /*               ); */

        /* $this->load->library('parser'); */
        /* $this->load->view('templates/header', $data); */
        /* $this->parser->parse('supplier/view', $data); */
        /* $this->load->view('templates/footer'); */
    }

    private function toUpdateSupplier(){
        $this->loadSupplierTemplate('update');
    }

    public function score(){
        $sid = $this->uri->segment(3);
        $data = array('sid'=>$sid);
        $this->load->library('parser');
        $this->load->view('templates/header', $data);
        $this->parser->parse('supplier/score', $data);
        $this->load->view('templates/footer');
    }

    public function delComment(){
        $id = $this->uri->segment(3);
        $sid = $this->input->post('sid');
        $result = $this->score_model->delById($id, $sid);
        echo json_encode($result);
        exit;
    }

    public function addScore(){
        $user = $this->getSessionUserInfo();
        $evaluator = $user['username'];
        /* show_error($evaluator); */
        $array = array(
                       'sid',
                       'project_name'=>'projectName',      
                       'project_location'=>'projectAddress',      
                       'project_period'=>'projectTime',
                       'project_type'=>'projectType',
                       'inquiry',
                       'inquired_product'=>'inquiredProduct',
                       'inquired_value'=>'inquiredValue',
                       'awarded',
                       'awarded_value'=>'awardedValue',
                       'prequalification',
                       'qualification',
                       'qualification_result'=>'qualificationResult',
                       'capability',
                       'compliance',
                       'financial',
                       'quality',
                       'cooperation',
                       'comments',
                       );
        $model = $this->formDataToModel($array, 'post');
        $model['evaluator'] = $evaluator;
        $model['addTime'] = date('Y-m-d H:i:s',time());
        /* show_error(implode(',', array_values($model))); */
        // get parameters from form.
        $result = $this->score_model->add($model);
        echo json_encode($result);
        exit;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
