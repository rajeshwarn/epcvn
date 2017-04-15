<?php
class Default_Model_Products extends Zend_Db_Table_Abstract{
    protected $_name = 'products';
    protected $_primary = 'id';

	public function getItems($params = null, $options = null) {
		$columns = isset($options['columns']) ? $options['columns'] : '*';
		$limit = isset($options['count']) ? $options['count'] : null;
		$offset = isset($options['offset']) ? intval($options['offset']) : 0;
		
		$select = $this->select()
					->setIntegrityCheck ( false )
					->from ( "{$this->_name} AS p", $columns)
					->join ( 'category AS c', 'c.id = p.categoryId', array('c.titleVi AS categoryNameVi', 'c.titleEn AS categoryNameEn', 'c.metaTitle AS catMetaTitle', 'c.metaKeyword AS catKeyword', 'c.metaDescription AS catMetaDes'))
					->where('p.status = 1')
					->where('c.status = 1')
					->where('p.isDelete = 0')
					->where('c.isDelete = 0');
		
    	if($options['task'] == 'by-category'){
    		$select->where('p.categoryId = ?', (int) $params['categoryId']);
    	}elseif($options['task'] == 'by-category-new'){
    		$select->where('p.categoryId = ?', (int) $params['categoryId']);
    		$select->where('p.isNew = 1');
    	}elseif($options['task'] == 'by-find-in-feature'){
    		$select->where('FIND_IN_SET('. $params['categoryId']. ', p.categorys)');
    		$select->where('p.featured = 1');
    	}elseif($options['task'] == 'by-find-in'){
    		$select->where('FIND_IN_SET('. $params['categoryId']. ', p.categorys)');
    	}elseif($options['task'] == 'by-country'){
    		$select->where('p.countryId = ?', (int) $params['countryId']);
    	}elseif($options['task'] == 'by-product-new'){
    		$select->where('p.isNew = 1');
    	}elseif($options['task'] == 'by-product-feature'){
    		$select->where('p.featured = 1');
    	}elseif($options['task'] == 'by-product-other'){
    		$select->where('p.id != ?',$params['id']);
    		$select->where('p.categoryId = ?',$params['categoryId']);
    	}
    	
    	$select->order(array('p.weight ASC', 'p.created DESC'));
    	$select->limit($limit, $offset);
    	
        $result = $this->fetchAll($select);
        
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }
    
    public function search($param, $options = null){
    	$columns = isset($options['columns']) ? $options['columns'] : '*';
    	$limit = isset($options['count']) ? $options['count'] : null;
    	$offset = isset($options['offset']) ? intval($options['offset']) : 0;
    	
    	$select = $this->select()
	    	->setIntegrityCheck ( false )
	    	->from ( "{$this->_name} AS p", $columns)
	    	->join ( 'category AS c', 'c.id = p.categoryId', array('c.titleVi AS categoryNameVi', 'c.titleEn AS categoryNameEn'))
	    	->where('p.status = 1')
	    	->where('c.status = 1')
	    	->where('p.isDelete = 0')
	    	->where('c.isDelete = 0')
	    	->where('p.titleVi LIKE "%'.$param.'%" OR p.titleEn LIKE "%'.$param.'%" OR p.introVi LIKE "%'.$param.'%" OR p.introEn LIKE "%'.$param.'%" OR c.titleVi LIKE "%'.$param.'%" OR c.titleEn LIKE "%'.$param.'%"');
    	
    	$select->order(array('p.weight ASC', 'p.created DESC'));
    	$select->limit($limit, $offset);
    	 
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
        	$select->where('id = ?', $params['id']);
        }
       
        $result =$this->fetchRow($select); 
        if ($result) {
            return $result->toArray();
        } else {
            return null;
        }
    }
    
    public function getFetchPairs($params = null, $options = null) {
		
		$query = "SELECT id, titleEn
		FROM $this->_name
		WHERE isDelete = 0 AND status = 1";
    	
		
		if($options['task'] == 'by-enquiry'){
			$query .= '  AND categoryId != 74';
		}
		
		$query .= ' ORDER BY weight ASC, created DESC';
    
    	return $this->_db->fetchPairs($query);
    }
    
    public function countItem($params, $options = null){
      $select = $this->select()
              ->setIntegrityCheck ( false )
		      ->from ( "{$this->_name} AS p", 'count(p.id) as total')
		      ->join ( 'category AS c', 'c.id = p.categoryId')
		      ->where('p.status = 1')
		      ->where('c.status = 1')
		      ->where('p.isDelete = 0')
		      ->where('c.isDelete = 0');
      
      if($options['task'] == 'by-category'){
      	$select->where('p.categoryId = ?', (int) $params['categoryId']);
      }elseif($options['task'] == 'by-category-new'){
      	$select->where('p.categoryId = ?', (int) $params['categoryId']);
      	$select->where('p.isNew = 1');
      }elseif($options['task'] == 'by-find-in-feature'){
      	$select->where('FIND_IN_SET('. $params['categoryId']. ', p.categorys)');
      	$select->where('p.featured = 1');
      }elseif($options['task'] == 'by-find-in'){
      	$select->where('FIND_IN_SET('. $params['categoryId']. ', p.categorys)');
      }elseif($options['task'] == 'by-country'){
      	$select->where('p.countryId = ?', (int) $params['countryId']);
      }elseif($options['task'] == 'by-product-new'){
      	$select->where('p.isNew = 1');
      }elseif($options['task'] == 'by-product-feature'){
      	$select->where('p.featured = 1');
      }elseif($options['task'] == 'by-search'){
      	$select->where('p.titleVi LIKE "%'.$param.'%" OR p.titleEn LIKE "%'.$param.'%" OR p.introVi LIKE "%'.$param.'%" OR p.introEn LIKE "%'.$param.'%" OR c.titleVi LIKE "%'.$param.'%" OR c.titleEn LIKE "%'.$param.'%"');
      }
      
      $result = $this->fetchRow($select);
      
      return $result->total;
    }
    
    public function updateItem($id,$info){
    	$this->update( $info, "id=" . (int) $id );
    
    }
}