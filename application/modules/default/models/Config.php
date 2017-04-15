<?php
class Default_Model_Config extends Zend_Db_Table_Abstract{
	protected $_name = 'config';
	protected $_primary = 'id';

	public function getItem($params = null, $options = null) {
		if($options == null){
			$select = $this->select();
		}elseif($options['task'] == 'by-name'){
			$select = $this->select()
			->from ( "{$this->_name} AS p" )
			->where('name = ?', $params);
		}
		 
		$result = $this->fetchAll($select);
		if ($result) {
			return $result->toArray();
		} else {
			return null;
		}
	}
}