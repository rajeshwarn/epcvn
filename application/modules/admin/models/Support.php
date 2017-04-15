<?php
class Admin_Model_Support extends Zend_Db_Table_Abstract{
    protected $_name = 'supports';
    protected $_primary = 'id';

	public function getItems($params = null, $options = null) {
		$columns = isset($options['columns']) ? $options['columns'] : '*';
		$limit = isset($options['count']) ? $options['count'] : null;
		$offset = isset($options['offset']) ? intval($options['offset']) : 0;
		
		$select = $this->select()
					->from ( "{$this->_name}", $columns)
					->where('status = 1');
		
		if(isset($params['status']) && $params['status'] != ''){
			$select->where('status = ?', (int) $params['status']);
		}
		if(isset($params['keyword'])){
			$select->where('nameVi LIKE '.'"%'. $params['keyword'].'%" OR nameEn LIKE '.'"%'. $params['keyword'].'%" OR mobile LIKE '.'"%'. $params['keyword'].'%" OR yahoo LIKE '.'"%'. $params['keyword'].'%" OR skype LIKE '.'"%'. $params['keyword'].'%"');
		}
    	
    	$select->order(array('weight ASC'));
    	$select->limit($limit, $offset);
        $result = $this->fetchAll($select);
        
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }

    public function countItems(){
    	$select = $this->select()
    	->from($this->_name,'count(id) as total');
    	
    	if(isset($params['status']) && $params['status'] != ''){
    		$select->where('status = ?', (int) $params['status']);
    	}
    	if(isset($params['keyword'])){
    		$select->where('nameVi LIKE '.'"%'. $params['keyword'].'%" OR nameEn LIKE '.'"%'. $params['keyword'].'%" OR mobile LIKE '.'"%'. $params['keyword'].'%" OR yahoo LIKE '.'"%'. $params['keyword'].'%" OR skype LIKE '.'"%'. $params['keyword'].'%"');
    	}
    	
    	$result = $this->fetchRow($select);
    	return $result->total;
    }
    
	public function getItemOne($id) {
        $select = $this->select()
                ->where('id = ?', (int) $id);
        
        $result =$this->fetchRow($select); 
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
}