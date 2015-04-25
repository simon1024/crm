<?php

class Supplier_model extends CI_Model {

    private $table = 'Supplier';

    //private $md5_prefix = 'psd_';

    public function __construct(){
        $this->load->database();
        //$this->config->load('myconfig');
    }

    function getCount($filter=array()){
        $filterArray = $this->genFilterSql($filter);
        /* $sql = "select count(*) as count from Supplier s where 1=1 $filterStr;"; */
        $sql = "select count(*) as count 
                from 
                (select s.id as id, chName, enName, service, city, 
                 score, s.no as no, country, addr, foundDate, vendorProperty, 
                 subCategory, website, contactor1, contactor2, qualification,
                 ct.tname as companyType, ft.fname as familyId, ca.cname as categoryId
                 from (select * from Supplier where 1=1 $filterArray[0]) s
                 left join CompanyType ct on ct.id=s.companyType 
                 left join Family ft on ft.id=s.familyId
                 left join Category ca on ca.id=s.categoryId ";
        if(!empty($filterArray[1])){
            $sql .= "right join ";
        }else {
            $sql .= "left join ";
        }
        $sql .= "(select distinct sid from Score where 1=1 $filterArray[1]) sc on sc.sid=s.id
                ) aa
                where  1=1 $filterArray[2] $filterArray[3];";
        /* show_error($sql); */

        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            return $row['count'];
        }

        return $this->db->count_all($this->table);
    }

    private function genFilterSql($filter){
        $filterStr = '';
        $filterStr2 = '';
        $filterStr3 = '';
        $filterStr4 = '';

        if(array_key_exists('name', $filter) && !empty($filter['name'])){
            $value = strtolower($filter['name']);
            $filterStr .= " and (lower(Supplier.chName) like '%$value%' or lower(Supplier.enName) like '%$value%') ";
        }
        if(array_key_exists('product', $filter) && !empty($filter['product'])){
            $value = strtolower($filter['product']);
            $filterStr .= " and lower(Supplier.service) like '%$value%' ";
        }
        if(array_key_exists('ptype', $filter) && $filter['ptype']>0){
            $value = $filter['ptype'];
            $filterStr2 .= " and Score.projectType=$value ";
        }
        if(array_key_exists('pname', $filter) && !empty($filter['pname'])){
            $value = strtolower($filter['pname']);
            $filterStr2 .= " and lower(Score.projectName) like '%$value%' ";
        }
        if(array_key_exists('others', $filter) && !empty($filter['others'])){
            $value = strtolower($filter['others']);
            $filterStr3 .= " and lower(concat_ws(',', aa.no, aa.country, aa.city, aa.addr, 
                             aa.foundDate, aa.vendorProperty, aa.subCategory, 
                             aa.website, aa.contactor1, aa.contactor2, aa.qualification,
                             aa.companyType, aa.familyId, aa.categoryId)) like '%$value%' ";
        }
        if(array_key_exists('sno', $filter) && strlen($filter['sno']) > 3 ){
            $value = strtolower($filter['sno']);
            $no = intval(subStr($value, -3));
            $familyName = subStr($value, 0, -3);
            $filterStr4 .= " and lower(aa.familyId)=\"$familyName\" and aa.no=$no";
        }

        return array($filterStr, $filterStr2, $filterStr3, $filterStr4);
    }

    function getListBaseInfo($filter, $offset, $limit){
        $offset = intval($offset);
        $limit = intval($limit);
        $filterArray = $this->genFilterSql($filter);

        $sql = "select aa.id, aa.no, aa.familyId, aa.chName, aa.enName, aa.companyType, aa.service, aa.city, aa.score 
                from 
                (select s.id as id, chName, enName, service, city, 
                 score, s.no as no, country, addr, foundDate, vendorProperty, 
                 subCategory, website, contactor1, contactor2, qualification,
                 ct.tname as companyType, ft.fname as familyId, ca.cname as categoryId
                 from (select * from Supplier where 1=1 $filterArray[0]) s
                 left join CompanyType ct on ct.id=s.companyType 
                 left join Family ft on ft.id=s.familyId
                 left join Category ca on ca.id=s.categoryId ";
        if(!empty($filterArray[1])){
            $sql .= "right join ";
        }else {
            $sql .= "left join ";
        }
        $sql .= "(select distinct sid from Score where 1=1 $filterArray[1]) sc on sc.sid=s.id
                ) aa
                where 1=1 $filterArray[2] $filterArray[3]
                limit $offset , $limit;";

        /* show_error($sql); */
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $row['noStr'] = $row["familyId"] . str_pad($row['no'], 3, "0", STR_PAD_LEFT);
            $data[] = $row;
        }
        return $data;
    }

    function add($data){
        // check username exists.
        $exists = $this->checkNameExists($data['chName']);
        if($exists){
            return array('status'=>'no', 'msg'=>'供应商已存在');
        }

        $keys = array_keys($data);
        $fields = implode(",", $keys);
        $values = "";
        foreach($data as $key=>$value) {
            $values .= "'$value' as $key";
            if($key != end($keys)) {
                $values .= ",";
            }
        }

        $familyId = $data['familyId'];
        $sql = "insert into Supplier(no,$fields) select max(no)+1 as no,$values from Supplier where familyId=$familyId;";
        /* show_error($sql); */

        $this->db->trans_start();
        $this->db->query($sql);
        $this->db->trans_complete();

        $message = '';
        $status = 'ok';
        if ($this->db->trans_status() === FALSE){
            $status = 'no';
            $message = "添加失败，错误代码 $errno ";
        }

        return array('status'=>$status, 'msg'=>$message);
    }


    function checkNameExists($name){
        $query = $this->db->get_where($this->table, array('chName' => $name), 1, 0);
        return $query->num_rows()>0? true: false;
    }

    function checkNoExists($no){
        $query = $this->db->get_where($this->table, array('no' => $no), 1, 0);
        return $query->num_rows()>0? true: false;
    }

    function login($userName, $pwd){
        $pwd = $this->md5_prefix . $pwd;
        $pwd = md5($pwd);
        $query = $this->db->get_where($this->table, array('username' => $userName, 'pwd'=>$pwd), 1, 0);
        $success = $query->num_rows()>0? true: false;
		if (!$success){
			$timeLimit = time() - 300;
			$this->db->where('username', $userName);
			$this->db->where('tmpPwd', $pwd); 
			$this->db->where('tmpTime >', $timeLimit); 
			$query = $this->db->get($this->table,1, 0);
			$success = $query->num_rows()>0? true: false;
			if($success) {
				$data = array('pwd' => $pwd,);
				$this->updateByUserName($userName, $data);
			}
		}
        $status  = 'no';
        $message = '用户名/密码错误';
        $user = array();
        if($success){
            $status = 'ok';
            $message = '';
            foreach ($query->result_array() as $row){
                $user = $row;
                break;
            }
        }
        return array('status'=>$status, 'msg'=>$message, 'user'=>$user);
    }



    function updateStatus($id, $data){
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

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

    function getBasicInfoById($id){
        $id = intval($id);
        $sql = "select s.id as sid, no, chName, enName, addr, city, country, zcode, foundDate, capital, staffNum,
                companyType, vendorProperty, service, familyId, categoryId, subCategory, website, qualification,
                telPhone1, cellPhone1, fax1, contactor1, position1, mail1,
                telPhone2, cellPhone2, fax2, contactor2, position2, mail2,
                c.tname as companyTypeName, f.fname as familyName, 
                ct.cname as categoryName, vp.property as vendorPropertyName
		from (select * from Supplier where Supplier.id=$id) s 
                left join CompanyType c on s.companyType=c.id
                left join Family f on s.familyId=f.id
                left join Category ct on s.categoryId=ct.id
                left join VendorProperty vp on s.vendorProperty=vp.id;
               ";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $row['noStr'] = $row["familyName"] . str_pad($row['no'], 3, "0", STR_PAD_LEFT);
            $data[] = $row;
        }
        return $data;

    }

    function update($id, $data){
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


    function getIdByUserName($userName){
        $query = $this->db->get_where($this->table, array('username' => $userName), 1, 0);
        $data = array();
        foreach ($query->result_array() as $row){
            return $row['id'];
        }
        return 0;
    }

    function exportByFilters($filter){
        $filterArray = $this->genFilterSql($filter);

        $result = "";
        $result .= "NO,Chinese Name,English Name,Country,City,Address,Zip Code,Found Date,";
        $result .= "Capital,Staff Num,Company Type,Vendor Property,Service/Product,Family ID,";
        $result .= "Category ID,Sub Category,Website,Contactor1,Position,Telephone NO,Mobilephone NO,";
        $result .= "Fax NO,Mail,Contactor2,Position,Telphone NO,Mobilephone NO,Fax NO,Mail,Qualification,Score \r\n";

        $sql = "select *
                from
                (select s.id as id, chName, enName, service, city, zcode,
                 capital, staffNum, score, s.no as no, country, addr, foundDate, 
                 vendorProperty, subCategory, website, qualification,
                 contactor1, position1, telPhone1, cellPhone1, fax1, mail1, 
                 contactor2, position2, telPhone2, cellPhone2, fax2, mail2,
                 ct.tname as companyType, ft.fname as familyId, ca.cname as categoryId
                 from (select * from Supplier where 1=1 $filterArray[0]) s
                 left join CompanyType ct on ct.id=s.companyType
                 left join Family ft on ft.id=s.familyId
                 left join Category ca on ca.id=s.categoryId ";
        if(!empty($filterArray[1])){
            $sql .= "right join ";
        }else {
            $sql .= "left join ";
        }
        $sql .= "(select distinct sid from Score where 1=1 $filterArray[1]) sc on sc.sid=s.id
                ) aa
                where 1=1 $filterArray[2] $filterArray[3];";

        $query = $this->db->query($sql);

        $fields = array("no", "chName", "enName", "country", "city", "addr", "zcode", "foundDate", 
                        "capital", "staffNum", "companyType", "vendorProperty", "service", "familyId",
                        "categoryId", "subCategory", "website", "contactor1", "position1", "telPhone1",
                        "cellPhone1", "fax1", "mail1", "contactor2", "position2", "telPhone2", "cellPhone2",
                        "fax2", "mail2", "qualification", "score");
        foreach ($query->result_array() as $row){
            foreach($fields as $field) {
                $item = "\"" . strtr($row[$field], "\"", "'") . "\"";
                $result .= $item . ",";
            }
            $result .= "\r\n";
        }
        /* show_error($result); */

        return $result;

    }
}
