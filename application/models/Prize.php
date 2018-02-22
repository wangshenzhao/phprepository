<?php


class PrizeModel{


    private $_table = 'prize';
    private $_db ;
    private $_collection;

    public function __construct(){
        $this->_db = Yaf_Registry::get("mongo");
        $this->_collection = $this->_db->selectCollection($this->_table);
    }

    public function getLists(){
        $where = array('type'=>101);
        $cursor = $this->_collection->find($where)->limit(5);
		$lists = iterator_to_array($cursor);
		return $lists;

    }
}