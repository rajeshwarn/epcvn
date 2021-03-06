<?php
class Admin_Model_Config extends Zend_Db_Table_Abstract{
    protected $_name = 'config';
    protected $_primary = 'id';

    public function getItemInfo($params = null, $options = null){
    	$select = $this->select();
    	if(isset($params['keyword'])){
    		$select->where('name LIKE '.'"%'. $params['keyword'].'%" OR value LIKE '.'"%'. $params['keyword'].'%"');
    	}
    	$select->order(array('weight ASC'));
    	return $select;
     
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
    
    public function getItem(){
    	$select = $this->select();
    	$result = $this->fetchAll($select);
    	if($result)
    		return $result->toArray();
    	else 
    		return null;
    	 
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
        
    public function removeItem($id){
    	try {
      			return $this->update(array('isDelete' => 1),"id =".(int) $id);
	      	} catch (Exception $e) {
	      		throw $e;
	      	}
    }
    
    public function removeAllItem(){
    	try {
    			return $this->update(array('isDelete' => 1));
    		} catch (Exception $e) {
    			throw $e;
    		}
    }
    
    public function restoreItem($id){
    	try {
    			return $this->update(array('isDelete' => 0),"id =".(int) $id);
    		} catch (Exception $e) {
    			throw $e;
    		}
    }
    
    public function deleteItem($id){
    	try {
    			return $this->update(array('isDelete' => 0),"id =".(int) $id);
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
}