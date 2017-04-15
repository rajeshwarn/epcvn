<?php

class Default_Model_CategoryArticle extends Zend_Db_Table_Abstract {

    protected $_name = 'category_article';
    protected $_primary = 'id';
        
    public function getItemInfo() {
        $select = $this->select()
        				->where('isDelete = 0');

        $results = $this->fetchAll($select);
        $system = new My_System_Recursive($results->toArray());
        $result = $system->buildArray(0);

        return $result;
    }

    public function getItemInSelectbox($arrParam = null, $options = null) {
        if ($options == null) {
            $select = $this->select()
                    ->from('category', array('id', 'titleVi', 'level', 'status', 'parentId', 'weight', 'createdBy'))
                    ->where('isDelete = 0')
                    ->order('weight ASC');
            $result = $this->fetchAll($select);
        }

        $recursive = new My_System_Recursive($result->toArray());

        $result = $recursive->buildArray(0);

        $tmp = array('id' => 0, 'titleVi' => '[-- Danh mục chính --]', 'level' => 1, 'weight' => 1, 'parentId' => 0);
        array_unshift($result, $tmp);

        return $result;
    }

    /**
     * get category select by parentId 
     * 
     * @param array $params
     * @param array $options
     * @return array
     */
    public function getFetchPairs($params = null, $options = null) {
        if ($options == null) {
            $query = "SELECT id, titleVi, parentId
                    FROM $this->_name 
            		WHERE isDelete = 0";
        } elseif ($options['task'] == 'by-id') {
            $id = $params['categoryId'];
            $query = "SELECT id, titleVi, parentId
                    FROM $this->_name
                    WHERE id = {$id} AND isDelete = 0";
        } elseif ($options['task'] == 'by-ids') {
            $ids = $params['categoryPath'];
            $query = "SELECT id, titleVi, parentId
                    FROM $this->_name
                    WHERE id IN ({$ids}) AND isDelete = 0";
        } elseif ($options['task'] == 'by-parent') {
            $parentId = $params['parentId'];
            $query = "SELECT id, titleVi, parentId
                    FROM $this->_name
                    WHERE parentId = {$parentId} AND isDelete = 0";
        }

        return $this->_db->fetchPairs($query);
    }

    public function getItems($param = null, $options = null) {
        if ($options == null) {
            $select = $this->select()
            		 ->where('isDelete = 0');
        } elseif ($options['task'] == 'by-id') {
            $select = $this->select()
                    ->where('id = ?', $param)
            		->where('isDelete = 0');
        } elseif ($options['task'] == 'by-parent') {
            $select = $this->select()
                    ->where('parentId = ?', $param)
            		->where('isDelete = 0');
        }elseif ($options['task'] == 'by-parent-featured') {
            $select = $this->select()
                    ->where('parentId = ?', $param)
            		->where('featured = 1')
            		->where('isDelete = 0');
        }elseif ($options['task'] == 'by-parent-in') {
            $select = $this->select()
                    ->where ('parentId IN ('. $param.')')
            		->where('isDelete = 0');
        }
       
        $result = $this->fetchAll($select);
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }

    public function getItemOne($params = null, $options = null) {
    	$columns = isset($options['columns']) ? $options['columns'] : '*';
    	
        $select = $this->select()
        		->from ( "{$this->_name}", $columns)
            	->where('isDelete = 0');
        
		if($options['task'] == 'by-alias'){
			$select->where('aliasVi = ?', $params['alias']);
			$select->orWhere('aliasEn = ?', $params['alias']);
		}else{
			$select->where('id = ?', (int) $params['id']);
		}
		
        $result = $this->fetchRow($select);
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }

    public function countItems() {
        $query = $this->select()
                ->from($this->_name, 'count(id) as total')
        		->where('isDelete = 0');
        $result = $this->fetchRow($query);
        
        if ($result) {
            return $result->total;
        } else {
            return null;
        }
    }

}