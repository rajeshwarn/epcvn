<?php
class Default_Model_SlideShow extends Zend_Db_Table_Abstract{
    protected $_name = 'slideshow';
    protected $_primary = 'id';

	public function getItems($options = null, $param = null) {
        $select = $this->select()
        			->setIntegrityCheck ( false )
					->from ( "{$this->_name} AS s")
					->where('status = 1');
					//->joinLeft ( 'category AS c', 'c.id = s.type OR c.parentId = s.type', array());
    	
        if($options['task'] == 'home'){
        	$select->where('s.type = 0');
        }
        
        if($options['task'] == 'child-category'){        	
        	$select->where('s.type = ?', (int) $param);
        }
        
        if($options['task'] == 'child-detail'){
        	$select->joinLeft ( 'articles AS a', 'a.categoryId = s.type', array());
        	$select->where('a.id = ?', (int) $param);
        }
        
        if($options['task'] == 'child-orther'){
        	$select->where('s.type != 0');
        }
        
        $select->group('s.id');
		$select->order(array('s.weight ASC', 's.created DESC'));
        
        $result = $this->fetchAll($select);
        
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }

	public function getItemOne($id) {
        $select = $this->select()
        		->where('isDelete = 0')
                ->where('id = ?', (int) $id);
        
        $result =$this->fetchRow($select); 
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }
    
    public function countItem(){
      $query = $this->select()
              ->from($this->_name,'count(id) as total');
      $result = $this->fetchRow($query);
      return $result->total;
    }
}