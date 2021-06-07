<?php
class Usermodel extends CI_Model {
    function registerUser()
    {
        $fullname = $this->input->post('full_name');
        $password = $this->input->post('password');
        $email  = $this->input->post('email');

        $data = array(
            'full_name' => $fullname,
            'created_by' => 1,
            'is_admin' => true,
            'password' =>md5($password),
            'email' =>$email
        );
        $sql = $this->db->insert('my_users', $data);
        $id = $this->db->insert_id();
        $q = $this->db->get_where('my_users', array('user_id' => $id));
        return $q->row();
    }
    function getRows($params = array(),$table){
        $this->db->select('*');
        $this->db->from($table);
        
        if(array_key_exists("where", $params)){
            foreach($params['where'] as $key => $val){
                $this->db->where($key, $val);
            }
        }
        
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
            $result = $this->db->count_all_results();
        }else{
            if(array_key_exists("id", $params)){
                $this->db->where('id', $params['id']);
                $query = $this->db->get();
                $result = $query->row_array();
            }else{
                $this->db->order_by('id', 'desc');
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->db->limit($params['limit'],$params['start']);
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                    $this->db->limit($params['limit']);
                }
                
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        
        // Return fetched data
        return $result;
    }
    
    public function insert($data = array()) {
        if(!empty($data)){
             $insert = $this->db->insert('my_users', $data);
             return $insert?$this->db->insert_id():false;
        }
        return false;
    }
    public function update($data, $condition = array()) {
        if(!empty($data)){
            $update = $this->db->update('my_users', $data, $condition);
            return $update?true:false;
        }
        return false;
    }
   }
?>