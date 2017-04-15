<?php
class Default_Model_Links extends Zend_Db_Table_Abstract{
    protected $_name = 'links';
    protected $_primary = 'id';

	public function getItems($params = null, $options = null) {
		$columns = isset($options['columns']) ? $options['columns'] : '*';
		$limit = isset($options['count']) ? $options['count'] : null;
		$offset = isset($options['offset']) ? intval($options['offset']) : 0;
		
		$select = $this->select()
					->from ( "{$this->_name}", $columns)
					->where('status = 1');
		
    	
    	$select->order(array('weight ASC', 'created DESC'));
    	$select->limit($limit, $offset);
    	
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