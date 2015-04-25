<?php

class Bill_model extends CI_Model {

    private $table = 'Project_Bill';

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

    function getAllBillByProjectId($pid){/*{{{*/
        $pid = intval($pid);
        $sql = "select * from Project_Bill where pid=$pid and status=3 ";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $id = $row['id'];
            $data[$id] = $row;
        }
        return $data;
    }/*}}}*/


    function del($id){
        $id = intval($id);
        $sql = "update Project_Bill set status=9 where id=$id ;";
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


}
