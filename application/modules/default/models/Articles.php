<?php
class Default_Model_Articles extends Zend_Db_Table_Abstract{
    protected $_name = 'articles';
    protected $_primary = 'id';

	public function getItems($params = null, $options = null) {
		$columns = isset($options['columns']) ? $options['columns'] : '*';
		$limit = isset($options['count']) ? $options['count'] : null;
		$offset = isset($options['offset']) ? intval($options['offset']) : 0;
		
		$select = $this->select()
					->setIntegrityCheck ( false )
					->from ( "{$this->_name} AS a", $columns)
					->join ( 'category_article AS c', 'c.id = a.categoryId', array('c.titleVi AS categoryNameVi', 'c.titleEn AS categoryNameEn','c.aliasVi AS catAliasVi', 'c.aliasEn AS catAliasEn',  'c.metaTitle AS catMetaTitle', 'c.metaKeyword AS catKeyword', 'c.metaDescription AS catMetaDes'))
					->where('a.status = 1')
					->where('c.status = 1')
					->where('a.isDelete = 0')
					->where('c.isDelete = 0');
		
    	if($options['task'] == 'by-category'){
    		$select->where('a.categoryId = ?', (int) $params['categoryId']);
    	}elseif($options['task'] == 'by-category-new'){
    		$select->where('a.categoryId = ?', (int) $params['categoryId']);
    		$select->where('a.isNew = 1');
    	}elseif($options['task'] == 'by-find-in-feature'){
    		$select->where('FIND_IN_SET('. $params['categoryId']. ', a.categorys)');
    		$select->where('a.featured = 1');
    	}elseif($options['task'] == 'by-find-in'){
    		$select->where('FIND_IN_SET('. $params['categoryId']. ', a.categorys)');
    	}elseif($options['task'] == 'by-country'){
    		$select->where('a.countryId = ?', (int) $params['countryId']);
    	}elseif($options['task'] == 'by-article-new'){
    		$select->where('a.isNew = 1');
    	}
    	
    	$select->order(array('a.weight ASC', 'a.created DESC'));
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
	    	->from ( "{$this->_name} AS a", $columns)
	    	->join ( 'category_article AS c', 'c.id = a.categoryId', array('c.titleVi AS categoryNameVi', 'c.titleEn AS categoryNameEn'))
	    	->where('a.status = 1')
	    	->where('c.status = 1')
	    	->where('a.isDelete = 0')
	    	->where('c.isDelete = 0')
	    	->where('a.titleVi LIKE "%'.$param.'%" OR a.titleEn LIKE "%'.$param.'%" OR a.introVi LIKE "%'.$param.'%" OR a.introEn LIKE "%'.$param.'%" OR c.titleVi LIKE "%'.$param.'%" OR c.titleEn LIKE "%'.$param.'%"');
    	
    	$select->order(array('a.weight ASC', 'a.created DESC'));
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
		      ->from ( "{$this->_name} AS a", 'count(a.id) as total')
		      ->join ( 'category_article AS c', 'c.id = a.categoryId')
		      ->where('a.status = 1')
		      ->where('c.status = 1')
		      ->where('a.isDelete = 0')
		      ->where('c.isDelete = 0');
      
      if($options['task'] == 'by-category'){
      	$select->where('a.categoryId = ?', (int) $params['categoryId']);
      }elseif($options['task'] == 'by-category-new'){
      	$select->where('a.categoryId = ?', (int) $params['categoryId']);
      	$select->where('a.isNew = 1');
      }elseif($options['task'] == 'by-find-in-feature'){
      	$select->where('FIND_IN_SET('. $params['categoryId']. ', a.categorys)');
      	$select->where('a.featured = 1');
      }elseif($options['task'] == 'by-find-in'){
      	$select->where('FIND_IN_SET('. $params['categoryId']. ', a.categorys)');
      }elseif($options['task'] == 'by-country'){
      	$select->where('a.countryId = ?', (int) $params['countryId']);
      }elseif($options['task'] == 'by-article-new'){
      	$select->where('a.isNew = 1');
      }elseif($options['task'] == 'by-search'){
      	$select->where('a.titleVi LIKE "%'.$param.'%" OR a.titleEn LIKE "%'.$param.'%" OR a.introVi LIKE "%'.$param.'%" OR a.introEn LIKE "%'.$param.'%" OR c.titleVi LIKE "%'.$param.'%" OR c.titleEn LIKE "%'.$param.'%"');
      }
      
      $result = $this->fetchRow($select);
      
      return $result->total;
    }
}