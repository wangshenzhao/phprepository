<?php
class AdminUserModel
{


    private $_table = 'admin_user';
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
    /**
     * 获取一条数据
     * @param $where
     */
    public function getOneInfo($where){
        $info = $this->_collection->findOne($where);
        return $info;

    }
    public function updateOne($data,$where){
        $result = $this->_collection->update($where,array('$set'=>$data));
        return $result;
    }
    public function del(){
        $result = $this->_collection->remove();
        return $result;
    }
    public function getList($where,$firstRow,$num){
        $result = $this->_collection->find($where)->sort(array('createTime'=>-1))->skip($firstRow)->limit($num);
        return iterator_to_array($result);
    }
    public function getNum($where){
        $num = $this->_collection->count($where);
        return $num;
    }
    public function remve($where){
        if(!$where || empty($where)){
            return false;
        }
        $result = $this->_collection->remove($where);
        return $result;
    }
}