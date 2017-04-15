<?php
class Admin_Model_UserRole extends Zend_Db_Table_Abstract{
    protected $_name = 'user_role';
	
    public function getItemOne($id) {
    	$select = $this->select()
    					->where('uId = ?',(int) $id);
    	$result = $this->fetchRow($select);
    	if ($result) {
    		return $result->toArray();
    	} else {
    		return null;
    	}
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
    			$data = array(
    				'roleId' => $info
    			);
     		 	return $this->update($data, "uId=" . (int) $id );;
		    } catch (Exception $e) {
		      	throw $e;
		    }
    }
    
    public function deleteItem($id){
    	try {
    			return $this->delete("uid =".(int) $id);
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
}