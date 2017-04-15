<?php
class Default_Model_Visited extends Zend_Db_Table_Abstract{
    protected $_name = 'visited';
    protected $_primary = 'id';


    public function init(){
        $this->_db = Zend_Db_Table::getDefaultAdapter(); 
    }
    public function Visited($options = null,$time = null,$day = null){
    	switch ($options) {
            case 'count':
                $select = $this->_db->fetchOne("SELECT count(*) as count from $this->_name where `datetime` = '{$time}'");
                return $select;
                break;
            case 'insert':
                $data = array('count' => 1,'datetime' => $time);

                $this->_db->insert($this->_name,$data);
                break;
            case 'update':
                $this->_db->query("update $this->_name  set `count` = `count` + 1 where `datetime` = '{$time}'  ");
                break;
            case 'count_day' : 
                //$select = $this->_db->query("SELECT sum(`count`) as tongcong from $this->_name where `datetime` BETWEEN '{$day}' AND '{$time}' ");
                $select = $this->select()
                                ->from($this->_name,("sum(`count`) as tongcong"))
                                ->where("datetime >= ?",$day)
                                ->where("datetime <= ?",$time);
                $result = $this->fetchRow($select);

                return $result->toArray();
                break;
            case 'count_total' :
                $select = $this->select()
                            ->from($this->_name,("sum(`count`) as tongcong"));
                $result = $this->fetchRow($select);
                return $result->toArray();
                break;
           	case 'day' :
                $select = $this->select()
                	->from($this->_name,("sum(`count`) as tongcong"))
                	->where("datetime =?",$time);
                $result = $this->fetchRow($select);
                return $result->toArray();
                break;
            default:
                $select = $this->_db->fetchOne("SELECT count(*) as count from $this->_name");
                return $select;
                break;
        }
     
    }


}