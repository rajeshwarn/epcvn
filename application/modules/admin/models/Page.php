<?php
class Admin_Model_Page extends Zend_Db_Table_Abstract{
    protected $_name = 'page';
    protected $_primary = 'id';

	public function getItems($params = null, $options = null){
    	$columns = isset($options['columns']) ? $options['columns'] : '*';
    	$limit = isset($options['count']) ? $options['count'] : null;
    	$offset = isset($options['offset']) ? intval($options['offset']) : 0;
    	
    	$select = $this->select()
    			->setIntegrityCheck ( false )
		    	->from ( "{$this->_name} AS a", $columns)
    			->where('a.isDelete = 0');
    	
    	
    	if(isset($params['status']) && $params['status'] != ''){
    		$select->where('a.status = ?', (int) $params['status']);
    	}
    	if(isset($params['keyword'])){
    		$select->where('a.titleVi LIKE '.'"%'. $params['keyword'].'%" OR a.titleEn LIKE '.'"%'. $params['keyword'].'%" OR a.introVi LIKE '.'"%'. $params['keyword'].'%" OR a.introEn LIKE '.'"%'. $params['keyword'].'%"');
    	}
    	
    	$select->order(array('a.modified DESC', 'a.created DESC'));
    	$select->limit($limit, $offset);
    	$select->group('a.id');
    		
    	$result = $this->fetchAll($select);
    	if ($result) {
    		return $result->toArray();
    	} else {
    		return null;
    	}
    
    }
    
    public function countItems($params = null, $options = null){
    	$select = $this->select()	
			    	->setIntegrityCheck ( false )
    				->from("{$this->_name} AS p",'count(p.id) as total')
    				->where('p.isDelete = 0');
    	
    	
    	if(isset($params['status']) && $params['status'] != ''){
    		$select->where('p.status = ?', (int) $params['status']);
    	}
    	if(isset($params['keyword'])){
    		$select->where('p.titleVi LIKE '.'"%'. $params['keyword'].'%" OR p.titleEn LIKE '.'"%'. $params['keyword'].'%" OR p.introVi LIKE '.'"%'. $params['keyword'].'%" OR p.introEn LIKE '.'"%'. $params['keyword'].'%"');
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
    	$this->update(array('isDelete' => 0),"id =".(int) $id);
    }
}