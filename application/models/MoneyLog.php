<?php
class MoneyLogModel{


    private $_table = 'money_log';
    private $_db ;
    private $_collection;

    public function __construct(){
        $this->_db = Yaf_Registry::get("mongo");
        $this->_collection = $this->_db->selectCollection($this->_table);
    }
    public function insert($data){
        $this->_collection->save($data);
        return $data;
    }
    public function updateOne($data,$where){
        $result = $this->_collection->update($where,array('$set'=>$data));
        return $result;
    }
    public function getLists($where,$firstRow,$num){
        $result = $this->_collection->find($where)->sort(array('createDate'=>-1))->skip($firstRow)->limit($num);
        return iterator_to_array($result);

    }

    /***
     * 获取当前条件的总数
     * @param $where
     */
    public function getNum($where){
        $num = $this->_collection->count($where);
        return $num;
    }

    /**
     * 获取一条数据
     * @param $where
     */
    public function getInfo($where){
        $info = $this->_collection->findOne($where);
        return $info;

    }

    /**
     * 更新用户数据
     * @param $where
     *
     */
    public function updateUser($where){
        $data = $where;
        unset($where);
        $where['_id'] = $data['_id'];
        unset($data['_id']);
        $result = $this->_collection->update($where,$data);
        return $result['updatedExisting'];
    }
}