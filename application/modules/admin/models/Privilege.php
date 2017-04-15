<?php

class Admin_Model_Privilege extends Zend_Db_Table_Abstract {

    protected $_name = 'privilege';
    protected $_primary = 'id';

    public function getItemInfo($params = null, $options = null){
    	$select = $this->select();
    	if($options['task'] == 'by-resourceId'){
    		$select->where('roleId = ?',(int) $params);
    	}
    	$result = $this->fetchAll($select);
    	if($result)
    		return $result->toArray();
    	else 
    		return false;
    }

    public function getItems(){
    	$select = $this->select();
    	$result = $this->fetchAll($select);
    	if ($result) {
    		return $result->toArray();
    	} else {
    		return null;
    	}
    
    }
    
    public function getItemOne($id) {
        $select = $this->select()
                ->where('id = ?', $id);
        $result = $this->fetchRow($select);
        if ($result) {
        	return $result->toArray();
        } else {
        	return null;
        }
    }

    public function addItem($info) {
    	try{
	        $data = array(
	            'roleId' => $info['roleId'],
	            'resourceId' => $info['resourceId']
	        );
        	$id = $this->insert($data);
    	}catch (Exception $e){
    		throw $e;
    	}
    }
    public function removeItem($id){
    	try {
    		return $this->update(array('isDelete' => 1),"uid =".(int) $id);
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
    public function deleteItem($roleId) {
    	try {
       		return $this->delete("roleId = " . (int) $roleId);
        } catch (Exception $e) {
        	throw $e;
        }
    }

    public function countItems() {
        $query = $this->select()
                ->from('users', 'count(uid) as total');
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