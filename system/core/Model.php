<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

	/**
	 * Constructor
	 *
	 * @access public
	 */
	function __construct()
	{
		log_message('debug', "Model Class Initialized");
	}

	/**
	 * __get
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string
	 * @access private
	 */
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}


    function getById($table, $id){
        $id = intval($id);
        $query = $this->db->get_where($table, array('id' => $id), 1, 0);
        $data = array();
        foreach ($query->result_array() as $row){
            return $row;
        }
        return array();
    }

    function updateById($table, $id, $data){
        $this->db->where('id', $id);
        $success = $this->db->update($table, $data); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';
        if($errno != 0){
            $status = 'no';
            $message = "更新失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

    function delById($table, $id){
        $data = array('status'=>'9');
        $this->db->where('id', $id);
        $success = $this->db->update($table, $data); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';

        if($errno != 0){
            $status = 'no';
            $message = "更新失败，错误代码 $errno ";
        }
        return array('status'=>$status, 'msg'=>$message);
    }

    function getResultBySql($sql){/*{{{*/
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }
        return $data;
    }/*}}}*/

    function getSingleResultBySql($sql){/*{{{*/
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            return $row;
        }
        return $data;
    }/*}}}*/




}
// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */
