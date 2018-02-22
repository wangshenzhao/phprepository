<?php
class ApplyModel
{


    private $_table = 'apply';
    private $_db;
    private $_collection;

    public function __construct()
    {
        $this->_db = Yaf_Registry::get("mongo");
        $this->_collection = $this->_db->selectCollection($this->_table);
    }
    public function getLists($where,$firstRow,$num){
        $result = $this->_collection->find($where)->sort(array('createDate'=>-1))->skip($firstRow)->limit($num);
        return iterator_to_array($result);

    }
    /**
     * 获取一条数据
     * @param $where
     */
    public function getOneInfo($where){
        $info = $this->_collection->findOne($where);
        return $info;

    }
    /***
     * 获取当前条件的总数
     * @param $where
     */
    public function getNum($where){
        $num = $this->_collection->count($where);
        return $num;
    }
    public function updateOne($data,$where){
        $result = $this->_collection->update($where,array('$set'=>$data));
        return $result;
    }
}