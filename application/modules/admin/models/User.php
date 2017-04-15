<?php

class Admin_Model_User extends Zend_Db_Table_Abstract {

    protected $_name = 'users';
    protected $_primary = 'uid';

    public function getItemInfo($params = null, $options = null){
    	$select = $this->select()
    	->where('isDelete = 0');
    	if(isset($params['status']) && $params['status'] != ''){
    		$select->where('status = ?', (int) $params['status']);
    	}
    	if(isset($params['keyword'])){
    		$select->where('userName LIKE '.'"%'. $params['keyword'].'%" OR fullname LIKE '.'"%'. $params['keyword'].'%"');
    	}
    	return $select;
    	 
    }
    public function getUserByUsername($username) {
        $select = $this->select()
                ->where('userName = ?', $username, STRING)
                ->where('status = ?', 1);
        return $this->fetchRow($select);
    }

    public function getItem(){
    	$select = $this->select()
    	->where('isDelete = 0');
    	$result = $this->fetchAll($select);
    	if ($result) {
    		return $result->toArray();
    	} else {
    		return null;
    	}
    
    }
    
    public function getUserOne($id) {
        $select = $this->select()
                ->where('uid = ?', $id)
                ->where('status = ?', 1);
        $result = $this->fetchRow($select);
        if ($result) {
        	return $result->toArray();
        } else {
        	return null;
        }
    }

    public function addItem($info) {
    	try{
    		$salt = $this->_generateSalt();
	        $data = array(
	            'userName' => $info['userName'],
	            'password' => md5(md5($info['password']) . $salt),
	            'email' => $info['email'],
	            'fullname' => $info['fullname'],
	            'salt' => $salt,
	            'status' => $info['status']
	        );
        $id = $this->insert($data);

        return $id;
    	}catch (Exception $e){
    		throw $e;
    	}
    }
	
	public function updateItem($id,$info){      
    	try { 
	    		$salt = $this->_generateSalt();
	    		$data = array(
	    				'userName' => $info['userName'],
			            'password' => md5(md5($info['password']) . $salt),
			            'email' => $info['email'],
			            'fullname' => $info['fullname'],
			            'salt' => $salt,
			            'status' => $info['status']
    		);
     		 	return $this->update( $data, "uid=" . (int) $id );
		    } catch (Exception $e) {
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
    public function deleteUser($uid) {
        $this->delete("uid = " . (int) $uid);
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