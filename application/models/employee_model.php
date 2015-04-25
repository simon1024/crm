<?php

class Employee_model extends CI_Model {

    private $table = 'Employee';

    private $md5_prefix = 'psd_';

    public function __construct(){
        $this->load->database();
        $this->config->load('myconfig');
    }

    function getCount($filter=array()){
        if(array_key_exists('name', $filter)){
            $value = $filter['name'];
            $sql = "select count(*) as count from Employee where name like '%$value%' or username like '%$value%';";
            $query = $this->db->query($sql); 
            $data = array();
            foreach ($query->result_array() as $row){
                return $row['count'];
            }
        }

        if(array_key_exists('department', $filter)){
            $value = $filter['department'];
            $sql = "select count(*) as count from Employee where department=$value;";
            $query = $this->db->query($sql); 
            $data = array();
            foreach ($query->result_array() as $row){
                return $row['count'];
            }
        }
        return $this->db->count_all($this->table);

    }

    function getListBaseInfo($filter, $offset, $limit){
        $offset = intval($offset);
        $limit = intval($limit);
        $nameFilter = '';
        if(array_key_exists('name', $filter)){
            $value = $filter['name'];
            $nameFilter = " where (e.name like '%$value%' or e.username like '%$value%')";
        }
        else if(array_key_exists('department', $filter)){
            $value = $filter['department'];
            $nameFilter = " where (e.department=$value)";
		}

        $sql = "select e.id, e.no, e.username, e.name, e.gender, d.name as department, p.name as position  from Employee e left join DeptType d on d.id=e.department  left join PositionType p on p.id=e.position $nameFilter and e.status=3 limit $offset , $limit;";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
  			if ($row['gender'] == '1')
            	$row['genderName'] = '男';
         	else
            	$row['genderName'] ='女';

            $data[] = $row;
        }
        return $data;
    }

    function add($data){
        // check username exists.
        $exists = $this->checkUserNameExists($data['username']);
        if($exists){
            return array('status'=>'no', 'msg'=>'用户名已存在');
        }
        // check no exits
        $exists = $this->checkNoExists($data['no']);
        if($exists){
            return array('status'=>'no', 'msg'=>'员工编号已存在');
        }

        $pwd = $this->md5_prefix . $data['pwd'];
        $data['pwd'] = md5($pwd);
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

    function checkUserNameExists($userName){
        $query = $this->db->get_where($this->table, array('username' => $userName), 1, 0);
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

    function del(){
    }

	/* 
	// old function, just set status to 9 for del
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

    function getBasicInfoById($id){
        $id = intval($id);
        $sql = "select e.id, e.no, e.name, e.username, e.gender, e.mail, e.role, e.tel, e.mobile, e.birthday, e.joinDate, d.id as department, p.id as position, le.username as leader  
		from Employee e 
		left join DeptType d on d.id=e.department  
		left join PositionType p on p.id=e.position 
		left join Employee le on le.id=e.leader
		where e.id=$id;";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
  			if ($row['gender'] == '1')
            	$row['genderName'] = '男';
         	else
            	$row['genderName'] ='女';

            $data[] = $row;
        }
        return $data;

    }

    function getPersonalInfoById($id){
        $id = intval($id);
        $sql = "select e.id, e.no, e.name, e.username, e.gender, e.mail, e.tel, e.mobile, e.birthday, e.joinDate, d.name as department, p.name as position, le.name as leader, ro.name as role  
		from Employee e 
		left join DeptType d on d.id=e.department  
		left join PositionType p on p.id=e.position 
		left join Employee le on le.id=e.leader
		left join RoleType ro on ro.id=e.role
		where e.id=$id;";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
  			if ($row['gender'] == '1')
            	$row['genderName'] = '男';
         	else
            	$row['genderName'] ='女';
            $data[] = $row;
        }
        return $data;

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


    function getIdByUserName($userName){
        $query = $this->db->get_where($this->table, array('username' => $userName), 1, 0);
        $data = array();
        foreach ($query->result_array() as $row){
            return $row['id'];
        }
        return 0;
    }

    function checkCurrentPasswd($id, $pwd){
        $pwd = $this->md5_prefix . $pwd;
        $pwd = md5($pwd);

        $query = $this->db->get_where($this->table, array('id' => $id), 1, 0);
        $data = array();
		$currentPwd = 0;
        $message = '';
        $status = 'ok';
        foreach ($query->result_array() as $row){
            $currentPwd = $row['pwd'];
        }

        if($currentPwd != $pwd){
            $status = 'no';
            $message = "密码有误";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

    function updatePwd($id, $data){
        $this->db->where('id', $id);
        $pwd = $this->md5_prefix . $data['pwd'];
        $data['pwd'] = md5($pwd);
        $this->db->update($this->table, $data); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';
        if($errno != 0){
            $status = 'no';
            $message = "密码修改失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

	function updateByUserName($username, $data){
        $this->db->where('username', $username);
        return $this->db->update($this->table, $data); 
	}

    function getMailByUserName($userName){
		//$userName = "Administrator";
        $query = $this->db->get_where($this->table, array('username' => $userName), 1, 0);
        $data = array();
        foreach ($query->result_array() as $row){
            return $row['mail'];
        }
        return "wrong";
    }

}
