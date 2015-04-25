<?php
class Score_model extends CI_Model {

    private $table = 'Score';

    public function __construct(){
        $this->load->database();
    }

    function getCount($filter=array()){
        if(array_key_exists('sid', $filter)){
            $sid = $filter['sid'];
            $sql = "select count(*) as count from Score where sid=$sid;";
            $query = $this->db->query($sql); 
            $data = array();
            foreach ($query->result_array() as $row){
                return $row['count'];
            }
        }

        return $this->db->count_all($this->table);

    }

    function getTotalScore($sid) {
        $sql = "select chName, enName, round(avg(capability),2) as capability, 
                round(avg(quality),2) as quality, round(avg(compliance),2) as compliance, 
                round(avg(cooperation),2) as cooperation, round(avg(financial),2) as financial
                from Score,Supplier
                where Score.sid=$sid and Supplier.id=$sid
                and Score.inquiry=1";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            if ($row['capability'] == NULL) {
                $row['total'] = 0;
                $row['sum'] = 0;
            } else {
                $row['total'] = round($row['capability'] * 0.25 + $row['quality'] * 0.25
                                      + $row['compliance'] * 0.1 + $row['cooperation'] * 0.25
                                      + $row['financial'] * 0.15, 2) ;
                $row['sum'] = round($row['capability'] + $row['quality'] + $row['compliance'] 
                                    + $row['cooperation'] + $row['financial'], 2);
            }

            $data[] = $row;
        }

        return $data;
    }

    function add($data){
        $success = $this->db->insert($this->table, $data); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';
        if($errno != 0){
            $status = 'no';
            $message = "添加失败，错误代码 $errno ";
        } else {
            $sid = $data['sid'];
            $totalScore = $this->getTotalScore($sid);
            $score = $totalScore[0]['total'];
            $this->db->where('id', $sid);
            $this->db->update("Supplier", array('score'=>$score)); 
        }

        return array('status'=>$status, 'msg'=>$message);
    }

    function getCommentsBySid($sid){
        $sid = intval($sid);
        $sql = "select * from Score 
		where Score.sid=$sid
                order by addTime desc;";

        $query = $this->db->query($sql); 
        $data = array();
        //just write into code now, can mv to db future
        $inquiry = array("Yes", "No");
        $projectType = array("EPC", "EPCM", "COST ESTIMATION");
        $awarded = array("Awarded by LBT", "Awarded by Client", "Not Awarded");
        $prequalification = array("Approved", "Approved with Condition", "Not Approved");
        $qualification = array("Supplier Survey", "Pre-Qotation", "End User Inquiry", "Others");
        $qualificationResult = array("Approved", "Approved with comments", "Not Approved");
        foreach ($query->result_array() as $row){
            $id = $row['id'];
            if($row['projectType']){
                $row['projectTypeName'] = $projectType[$row['projectType'] - 1];
            }else {
                $row['projectTypeName'] = "";
            }
            if($row['awarded']) {
                $row['awardedName'] = $awarded[$row['awarded'] - 1];
            }else {
                $row['awardedName'] = "";
            }
            if($row['prequalification']) {
                $row['prequalificationName'] = $prequalification[$row['prequalification'] - 1];
            }else {
                $row['prequalificationName'] = "";
            }
            if($row['qualification']) {
                $row['qualificationName'] = $qualification[$row['qualification'] - 1];
            }else {
                $row['qualificationName'] = "";
            }
            if($row['qualificationResult']){
                $row['qualificationResultName'] = $qualificationResult[$row['qualificationResult'] - 1];
            }else {
                $row['qualificationResultName'] = "";
            }
            if($row['inquiry']) {
                $row['inquiryName'] = $inquiry[$row['inquiry'] - 1];
            }else {
                $row['inquiryName'] = "";
            }

            $data[$id] = $row;
        }
        return $data;
    }

    function delById($id, $sid){
        $id = intval($id);
        $sid = intval($sid);
        $data = array('id'=>$id);
        $success = $this->db->delete($this->table, $data); 
        $errno = $this->db->_error_number();
        $message = '';
        $status = 'ok';
        if($errno != 0){
            $status = 'no';
            $message = "删除失败，错误代码 $errno ";
        }else {
            $totalScore = $this->getTotalScore($sid);
            $score = $totalScore[0]['total'];
            $this->db->where('id', $sid);
            $this->db->update("Supplier", array('score'=>$score)); 
        }

        return array('status'=>$status, 'msg'=>$message);
    }
}
