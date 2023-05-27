<?php
namespace app\common\model;
use think\Model;

class PostInfoModel extends Model {
    /*关联表名*/
    protected $table  = 't_postInfo';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    //发帖人复合属性的获取: 多对一关系
    public function userObjF(){
        return $this->belongsTo('UserInfoModel','userObj');
    }

    /*添加帖子记录*/
    public function addPostInfo($postInfo) {
        $this->insert($postInfo);
    }

    /*更新帖子记录*/
    public function updatePostInfo($postInfo) {
        $this->update($postInfo);
    }

    /*增加浏览量*/
    public function setIncViewNum($postInfoId) {
        PostInfoModel::where("postInfoId=".$postInfoId)->setInc("hitNum",1);
    }

    /*删除多条帖子信息*/
    public function deletePostInfos($postInfoIds){
        $postInfoIdArray = explode(",",$postInfoIds);
        foreach ($postInfoIdArray as $postInfoId) {
            $this->postInfoId = $postInfoId;
            $this->delete();
        }
        return count($postInfoIdArray);
    }
    /*根据主键获取帖子记录*/
    public function getPostInfo($postInfoId) {
        $postInfo = PostInfoModel::where("postInfoId",$postInfoId)->find();
        return $postInfo;
    }

    /*按照查询条件分页查询帖子信息*/
    public function queryPostInfo($title, $userObj, $addTime, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($title != "") $where['title'] = array('like','%'.$title.'%');
        if($userObj['user_name'] != "") $where['userObj'] = $userObj['user_name'];
        if($addTime != "") $where['addTime'] = array('like','%'.$addTime.'%');
        $postInfoRs = PostInfoModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = PostInfoModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $postInfoRs;
    }

    /*按照查询条件查询所有帖子记录*/
  public function queryOutputPostInfo( $title,  $userObj,  $addTime) {
        $where = null;
        if($title != "") $where['title'] = array('like','%'.$title.'%');
        if($userObj['user_name'] != "") $where['userObj'] = $userObj['user_name'];
        if($addTime != "") $where['addTime'] = array('like','%'.$addTime.'%');
        $postInfoRs = PostInfoModel::where($where)->select();
        return $postInfoRs;
    }

    /*查询所有帖子记录*/
    public function queryAllPostInfo(){
        $postInfoRs = PostInfoModel::where(null)->select();
        return $postInfoRs;

    }

}
