<?php
class Default_Model_UserOnline extends Zend_Db_Table_Abstract{
    protected $_name = 'user_online';
    protected $_primary = 'id';


    public function init(){
        $this->_db = Zend_Db_Table::getDefaultAdapter(); 
    }
    public function UserOnline($options = null,$session_time = null,$time = null,$timecheck = null){
    	switch ($options) {
            case 'count':
                $select = $this->_db->fetchOne("SELECT count(*) as count from $this->_name where `session_time` = '{$session_time}'");
                return $select;
                break;
            case 'insert':
                $data = array('session_time' => $session_time,'time' => $time);
                $this->_db->insert($this->_name,$data);
                break;
            case 'update':
                $data = array('time' => $time);
                $this->_db->update($this->_name,$data,"session_time = '{$session_time}'");
                break;
            case 'delete':
                $this->_db->delete($this->_name,"time < '{$timecheck}'");
                break;
            default:
                $select = $this->_db->fetchOne("SELECT count(*) as count from $this->_name");
                return $select;
                break;
        }
     
    }


}