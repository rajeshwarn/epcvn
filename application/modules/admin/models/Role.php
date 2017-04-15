<?php
class Admin_Model_Role extends Zend_Db_Table_Abstract{
    protected $_name = 'role';
    protected $_primary = 'id';

    public function getItemInfo($params = null, $options = null){
    	$select = $this->select();
    	if(isset($params['keyword'])){
    		$select->where('CityName LIKE '.'"%'. $params['keyword'].'%"');
    	}
    	return $select;
     
    }
    
    public function getItem(){
    	$select = $this->select();
    	$result = $this->fetchAll($select);
    	if ($result) {
    		return $result->toArray();
    	} else {
    		return null;
    	}
    
    }
    
    public function getItemOne($id){
        $select = $this->select()
                      ->where('id = ?', $id);
        $result = $this->fetchRow($select);
        if ($result) {
        	return $result->toArray();
        } else {
        	return null;
        }
        
    }
    
    public function getItemInSelectbox(){
    	$select = $this->select();
    	$result = $this->fetchAll($select);
    
    	return $result;
    
    }

    public function addItem($info){      
    	try {
	    		$id = $this->insert($info);
	     	 	return $id;
	     	 } catch (Exception $e) {
	     	 	throw $e;
	     	 }
    }

    public function updateItem($id,$info){      
    	try { 
     		 	return $this->update( $info, "id=" . (int) $id );
		    } catch (Exception $e) {
		      	throw $e;
		    }
    }
    
    public function deleteItem($id){
    	try {
    			return $this->delete("id =".(int) $id);
    		} catch (Exception $e) {
    			throw $e;
    		}
    }
    public function deleteAllItem(){
    	try {
    		return $this->delete();
    	} catch (Exception $e) {
    		throw $e;
    	}
    }
    public function countItems(){
      $query = $this->select()
              ->from($this->_name,'count(id) as total');
      $result = $this->fetchRow($query);
      return $result->total;
    }
    private function _generateSalt($length = 3) {
    	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    	$string = '';
    	for ($p = 0; $p < $length; $p++) {
    		$string .= $characters[mt_rand(0, (strlen($characters) - 1))];
    	}
    	return $string;
    }
}