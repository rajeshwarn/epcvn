<?php
class Admin_Model_Product extends Zend_Db_Table_Abstract{
    protected $_name = 'products';
    protected $_primary = 'id';

    public function getItems($params = null, $options = null){
    	$columns = isset($options['columns']) ? $options['columns'] : '*';
    	$limit = isset($options['count']) ? $options['count'] : null;
    	$offset = isset($options['offset']) ? intval($options['offset']) : 0;
    	
    	$select = $this->select()
    			->setIntegrityCheck ( false )
		    	->from ( "{$this->_name} AS p", $columns)
    			->join('category AS c', 'c.id = p.categoryId', array('c.titleVi AS CategoryNameVi', 'c.titleEn AS CategoryNameEn'))
    			->where('p.isDelete = 0')
				->where('c.isDelete = 0');
    	
    	if(isset($params['categoryId']) && $params['categoryId'] != ''){
    		$select->where('p.categoryId = ?', (int) $params['categoryId']);
    	}
    	if(isset($params['status']) && $params['status'] != ''){
    		$select->where('p.status = ?', (int) $params['status']);
    	}
    	if(isset($params['keyword'])){
    		$select->where('p.titleVi LIKE '.'"%'. $params['keyword'].'%" OR p.titleEn LIKE '.'"%'. $params['keyword'].'%" OR p.introVi LIKE '.'"%'. $params['keyword'].'%" OR p.introEn LIKE '.'"%'. $params['keyword'].'%"');
    	}
    	
    	if($options['task'] == 'admin-product-new'){
    		$select->where('p.isNew = 1');
    	}elseif($options['task'] == 'admin-product-feature'){
    		$select->where('p.featured = 1');
    	}
    	
    	if($options['task'] == 'admin-views'){
    		$select->order(array('p.views DESC'));
    	}else{
    		$select->order(array('p.weight ASC', 'p.modified DESC', 'p.created DESC'));
    	}
    	
    	$select->limit($limit, $offset);
    	$select->group('p.id');
    		
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
    				->join('category AS c', 'c.id = p.categoryId', array())
    				->where('p.isDelete = 0')
    				->where('c.isDelete = 0');
    	
    	if(isset($params['categoryId']) && $params['categoryId'] != ''){
    		$select->where('p.categoryId = ?', (int) $params['categoryId']);
    	}
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