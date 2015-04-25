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

    function getAwardedTotal($sid){
        $sql = "select sum(awardedValue) as awardedTotal from Score where Score.sid=$sid";
        $query = $this->db->query($sql); 
        $data = array();
        $awardedTotal = 0;
        foreach ($query->result_array() as $row){
            $awardedTotal = $row['awardedTotal'];
        }

        return $awardedTotal;
    }

    function getTotalScore($sid) {
        $sql = "select chName, enName, count(*) as inquiryCount, 
                round(avg(capability),2) as capability, 
                round(avg(quality),2) as quality, round(avg(compliance),2) as compliance, 
                round(avg(cooperation),2) as cooperation, round(avg(financial),2) as financial
                from Score,Supplier
                where Score.sid=$sid and Supplier.id=$sid
                and Score.inquiry=1";
        $query = $this->db->query($sql); 
        $data = array();
        foreach ($query->result_array() as $row){
            $row['awardedTotal'] = $this->getAwardedTotal($sid);
            if ($row['capability'] == NULL) {
                $row['total'] = 0;
            } else {
                $row['total'] = round($row['capability'] * 0.20 + $row['quality'] * 0.25
                                      + $row['compliance'] * 0.10 + $row['cooperation'] * 0.25
                                      + $row['financial'] * 0.20, 2) ;
            }

            if ($row['inquiryCount'] > 0) {
                $row['inquiry'] = 'Yes';
            }else {
                $row['inquiry'] = 'No';
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
            $inquiryCount = $totalScore[0]['inquiryCount'];
            $awardedTotal = $totalScore[0]['awardedTotal'];
            $this->db->where('id', $sid);
            $this->db->update("Supplier", array('score'=>$score, 'inquiryCount'=>$inquiryCount, 'awardedTotal'=>$awardedTotal)); 
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
            $row['capability'] = $row['capability'] * 0.2;
            $row['compliance'] = $row['compliance'] * 0.1;
            $row['financial'] = $row['financial'] * 0.2;
            $row['quality'] = $row['quality'] * 0.25;
            $row['cooperation'] = $row['cooperation'] * 0.25;
            $row['total'] = $row['capability'] + $row['compliance'] + $row['financial'] + $row['quality'] + $row['cooperation'] ;

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
        /* show_error($sid); */
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
            $inquiryCount = $totalScore[0]['inquiryCount'];
            $awardedTotal = $totalScore[0]['awardedTotal'];
            $this->db->where('id', $sid);
            $this->db->update("Supplier", array('score'=>$score, 'inquiryCount'=>$inquiryCount, 'awardedTotal'=>$awardedTotal)); 
        }

        return array('status'=>$status, 'msg'=>$message);
    }

    function delBySupplierId($sid){
        /* show_error($sid); */
        $sid = intval($sid);
        $data = array('sid'=>$sid);
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
}
