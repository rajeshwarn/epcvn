<?php
class Admin_Model_Category extends  Zend_Db_Table_Abstract {
	protected $_name = 'category';
	protected $_primary = 'id';
	protected $_dependentTables = array('Admin_Model_Product');
	
	public function getCategoryInfo( $param = null, $options = null) {
		if($options == null) {
			$select = $this->select()
							->where('isDelete = 0');
		}elseif ($options['task'] == 'trash'){
			$select = $this->select()
						->where('isDelete = 1');
		}
		
		$results = $this->fetchAll($select);
		$system = new My_System_Recursive($results->toArray());
		$result = $system->buildArray(0);
	
		return $result;
	}
	
	public function getItemInSelectbox($arrParam = null, $options = null) {
		
			$select = $this->select()
			->from('category', array('id', 'titleVi', 'level', 'status', 'parentId', 'weight', 'createdBy'))
			->where('isDelete = 0')
			->order('weight ASC');
			$result = $this->fetchAll($select);
		
		$recursive = new My_System_Recursive($result->toArray());
		$result = $recursive->buildArray(0);
		if ($options == null) {
			$tmp = array('id' => '', 'titleVi' => '[-- Danh mục chính --]', 'level' => 1, 'weight' => 1, 'parentId' => 0);
		}elseif ($options['task'] == 'filter'){
			$tmp = array('id' => '', 'titleVi' => PLEASE_SELECT, 'level' => 1, 'weight' => 1, 'parentId' => 0);
		}
		array_unshift($result, $tmp);
	
		return $result;
	}
	
	public function getFetchPairs($params = null, $options = null) {
		if ($options == null) {
			$query = "SELECT id, titleEn, parentId
			FROM $this->_name
			WHERE isDelete = 0";
		} elseif ($options['task'] == 'by-id') {
				$id = $params['categoryId'];
				$query = "SELECT id, titleEn, parentId
				FROM $this->_name
				WHERE id = {$id} AND isDelete = 0";
		} elseif ($options['task'] == 'by-ids') {
			$ids = $params['categoryPath'];
			$query = "SELECT id, titleEn, parentId
			FROM $this->_name
			WHERE id IN ({$ids}) AND isDelete = 0";
		} elseif ($options['task'] == 'by-parent') {
			$parentId = $params['parentId'];
			$query = "SELECT id, titleEn
			FROM $this->_name
			WHERE parentId = {$parentId} AND isDelete = 0";
		}
		
		
		$result = $this->_db->fetchPairs($query);
		
		/* $recursive = new My_System_Recursive($result);
		
		$results = $recursive->buildArray(0); */
		return $result;
	}
	
	public function getCategorys($params = null, $options = null) {
		if ($options == null) {
			$select = $this->select()
			->where('isDelete = 0');
		} elseif ($options['task'] == 'by-id') {
			$select = $this->select()
			->where('id = ?', $params)
			->where('isDelete = 0');
		} elseif ($options['task'] == 'by-parent') {
			$select = $this->select()
			->where('parentId = ?', $params)
			->where('isDelete = 0');
		} elseif ($options['task'] == 'by-parent-in') {
			$select = $this->select()
			->where('parentId IN ('. $params.')')
			->where('isDelete = 0');
		}	
		$result = $this->fetchAll($select);
		if ($result) {
			return $result->toArray();
		} else {
			return null;
		}
	}
	
	public function getCategoryOne($id) {
		$select = $this->select()
		->where('id = ?', (int) $id)
		->where('isDelete = 0');
	
		$result = $this->fetchRow($select);
		if ($result) {
			return $result->toArray();
		} else {
			return null;
		}
	}
	
	
	public function addItem($info) {
		try {
			$id = $this->insert($info);
			 
			return $id;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function updateItem($id, $info) {
		try {
			$result = $this->update($info, "id=" . (int) $id);
			 
			return $result;
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	 public function removeAllItem(){
	 	try {
	 		$result = $this->update(array("isDelete" => 1));
	 		return $result;
	 	} catch (Exception $e) {
	 		throw $e;
	 	}
	 }
	 
	 public function removeItem($params = null, $options = null) {
	 	try {
	 		$data = array('isDelete' => 1);
	 		if($options == null){
	 			$result = $this->updateItem($params, $data);
	 		}elseif($options['task'] == 'remove-select'){
	 			foreach($params as $key => $val){
	 				$result = $this->updateItem($val, $data);
	 			}
	 		}elseif($options['task'] == 'remove-all'){
	 			$params = $this->getCategorys();
	 			 
	 			foreach($params as $key => $val){
	 				$result = $this->updateItem($val['id'], $data);
	 			}
	 		}
	 	  
	 		return $result;
	 	} catch (Exception $e) {
	 		throw $e;
	 	}
	 }
	 
	 public function restoreItem($params = null, $options = null) {
	 	try {
	 		$data = array('isDelete' => 0);
	 
	 		if($options == null){
	 			$result = $this->updateItem($params, $data);
	 		}elseif($options['task'] == 'restore-select'){
	 			foreach($params as $key => $val){
	 				$result = $this->updateItem($val, $data);
	 			}
	 		}elseif($options['task'] == 'restore-all'){
	 			$params = $this->getFeatureDetail();
	 			 
	 			foreach($params as $key => $val){
	 				$result = $this->updateItem($val, $data);
	 			}
	 		}
	 			
	 		return $result;
	 	} catch (Exception $e) {
	 		throw $e;
	 	}
	 }
	 
	 public function deleteItem($params = null, $options = null) {
	 	try {
	 		if($options == null){
	 			$categoryRowset = $this->find($params);
	 			$category = $categoryRowset->current();
	 			$result = $category->delete();
	 		}elseif($options['task'] == 'delete-select'){
	 			foreach($params as $key => $val){
	 				$categoryRowset = $this->find($val);
	 				$category = $categoryRowset->current();
	 				$result = $category->delete();
	 			}
	 		}elseif($options['task'] == 'delete-all'){
	 			$params = $this->getCategorys();
	 
	 			foreach($params as $key => $val){
	 				$categoryRowset = $this->find($val);
	 				$category = $categoryRowset->current();
	 				$result = $category->delete();
	 			}
	 		}
	 			
	 		return $result;
	 	} catch (Exception $e) {
	 		throw $e;
	 	}
	 }
	
}