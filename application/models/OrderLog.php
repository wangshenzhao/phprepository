<?php
class OrderLogModel
{
    private $_table = 'order_log';
    private $_db;
    private $_collection;

    public function __construct()
    {
        $this->_db = Yaf_Registry::get("mongo");
        $this->_collection = $this->_db->selectCollection($this->_table);
    }
    public function getNum($where){
        $num = $this->_collection->count($where);
        return $num;
    }
    public function getList($where,$firstRow,$num){
        $result = $this->_collection->find($where)->sort(array('addTime'=>-1))->skip($firstRow)->limit($num);
        return iterator_to_array($result);
    }
}