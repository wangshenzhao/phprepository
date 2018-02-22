<?php
class MenuModel{


    private $_table = 'menu';
    private $_db ;
    private $_collection;

    public function __construct(){
        $this->_db = Yaf_Registry::get("mongo");
        $this->_collection = $this->_db->selectCollection($this->_table);
    }
    public function addMenu($data){
        $result = $this->_collection->save($data);
        return $result;
    }
    public function updateOne($data,$where){
        $result = $this->_collection->update($where,array('$set'=>$data));
        return $result;
    }
    public function updateInfo($data,$where){
        $result=$this->_collection->update($where,$data);
        return $result;
    }
    public function getLists($where,$firstRow,$num){
        $result = $this->_collection->find($where)->sort(array('stat'=>-1))->skip($firstRow)->limit($num);
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
    /*
     * 获取用户名
     */
    public function getCompany($where){
        $info = $this->_collection->findOne($where);
        return $info['company'];
    }
    /**
     * 获取全部数据
     * @param $where
     */
    public function getAll($where){
        $info = $this->_collection->find($where)->sort(array('stat'=>-1));
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
        $result = $this->_collection->update($where,array('$set'=>$data));
        return $result['updatedExisting'];
    }

    /**
     * 清楚脏数据
     */
    public function del(){
        $result = $this->_collection->remove();
        return $result;
    }


    public function testArray(){
        $where = array(
            'userId'    =>'bst59e73d9d845180682900002c'
        );
        $data = array(
            '$set'  =>array(
                'comments'=>array(
                    array('by'=>'joe','votes'=>111),
                    array('by'=>'jane','votes'=>3)
                )
            )
        );
        $this->_collection->update($where,$data);
        $data =array(
            '$set'  =>array(
                'comments.0.votes'  =>222
            )
        );
        $this->_collection->update($where,$data);
        $data = array(
            '$push' =>array(
                'comments'  =>array('by'=>'coin','votes'=>55)
            )
        );
        $this->_collection->update($where,$data);
    }

    //修改数据
    public function upSert($where,$data){
        if(empty($where) || empty($data)){
            return false;
        }
        if( $this->_collection->findOne($where)) {
           return $this->_collection->update($where, $data);
        }else{
           return $this->_collection->insert($data);
        }
    }
    public function remve($where){
        if(!$where || empty($where)){
            return false;
        }
        $result = $this->_collection->remove($where);
        return $result;
    }
}