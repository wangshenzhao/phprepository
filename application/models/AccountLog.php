<?php
class AccountLogModel
{
    private $_table = 'account_log';
    private $_db;
    private $_collection;

    public function __construct()
    {
        $this->_db = Yaf_Registry::get("mongo");
        $this->_collection = $this->_db->selectCollection($this->_table);
    }

    public function insert($data)
    {
        $this->_collection->save($data);
        return $data;
    }
}