<?php
class Admin_Model_Video extends Zend_Db_Table_Abstract{
    protected $_name = 'video';
    protected $_primary = 'id';

    public function getItems($params = null, $options = null){
    	$columns = isset($options['columns']) ? $options['columns'] : '*';
    	$limit = isset($options['count']) ? $options['count'] : null;
    	$offset = isset($options['offset']) ? intval($options['offset']) : 0;
    	
    	$select = $this->select()
		    	->from ( "{$this->_name}", $columns)
				->where('isDelete = 0');
    	
    	if(isset($params['status']) && $params['status'] != ''){
    		$select->where('status = ?', (int) $params['status']);
    	}
    	if(isset($params['keyword'])){
    		$select->where('youtube LIKE '.'"%'. $params['keyword'].'%" OR code LIKE '.'"%'. $params['keyword'].'%"');
    	}
    	
    	$select->order(array('weight ASC', 'modified DESC', 'created DESC'));
    	$select->limit($limit, $offset);
    		
    	$result = $this->fetchAll($select);
    	if ($result) {
    		return $result->toArray();
    	} else {
    		return null;
    	}
    
    }
    
    public function countItems($params = null, $options = null){
    	$select = $this->select()	
    				->from("{$this->_name}",'count(id) as total')
    				->where('isDelete = 0');
    	
    	
    	if(isset($params['status']) && $params['status'] != ''){
    		$select->where('status = ?', (int) $params['status']);
    	}
    	if(isset($params['keyword'])){
    		$select->where('youtube LIKE '.'"%'. $params['keyword'].'%" OR code LIKE '.'"%'. $params['keyword'].'%"');
    	}
    	
    	$result = $this->fetchRow($select);
    	return $result->total;
    }
    
    public function getItemInSelectbox(){
    	$select = $this->select();
    	$result = $this->fetchAll($select);
    	
    	return $result;
    	
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

    public function addItem($info){      
      $id = $this->insert( $info );
      
      return $id;
    }

    public function updateItem($id,$info){       
      $this->update( $info, "id=" . (int) $id );
      
    }
        
    public function removeItem($id){
      	return $this->update(array('isDelete' => 1),"id =".(int) $id);
    }
    
    public function removeAllItem(){
    	return $this->update(array('isDelete' => 1));
    }
    
    public function restoreItem($id){
    	return $this->update(array('isDelete' => 0),"id =".(int) $id);
    }
    
    
    public function deleteItem($id){
    	$this->delete("id = ". (int) $id);
    }
    
    
}