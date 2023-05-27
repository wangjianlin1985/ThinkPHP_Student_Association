<?php
namespace app\common\model;
use think\Model;

class ReplyModel extends Model {
    /*关联表名*/
    protected $table  = 't_reply';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    //被回帖子复合属性的获取: 多对一关系
    public function postInfoObjF(){
        return $this->belongsTo('PostInfoModel','postInfoObj');
    }

    //回复人复合属性的获取: 多对一关系
    public function userObjF(){
        return $this->belongsTo('UserInfoModel','userObj');
    }

    /*添加帖子回复记录*/
    public function addReply($reply) {
        $this->insert($reply);
    }

    /*更新帖子回复记录*/
    public function updateReply($reply) {
        $this->update($reply);
    }

    /*删除多条帖子回复信息*/
    public function deleteReplys($replyIds){
        $replyIdArray = explode(",",$replyIds);
        foreach ($replyIdArray as $replyId) {
            $this->replyId = $replyId;
            $this->delete();
        }
        return count($replyIdArray);
    }
    /*根据主键获取帖子回复记录*/
    public function getReply($replyId) {
        $reply = ReplyModel::where("replyId",$replyId)->find();
        return $reply;
    }

    /*按照查询条件分页查询帖子回复信息*/
    public function queryReply($postInfoObj, $userObj, $replyTime, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($postInfoObj['postInfoId'] != 0) $where['postInfoObj'] = $postInfoObj['postInfoId'];
        if($userObj['user_name'] != "") $where['userObj'] = $userObj['user_name'];
        if($replyTime != "") $where['replyTime'] = array('like','%'.$replyTime.'%');
        $replyRs = ReplyModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = ReplyModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $replyRs;
    }

    /*按照查询条件查询所有帖子回复记录*/
  public function queryOutputReply( $postInfoObj,  $userObj,  $replyTime) {
        $where = null;
        if($postInfoObj['postInfoId'] != 0) $where['postInfoObj'] = $postInfoObj['postInfoId'];
        if($userObj['user_name'] != "") $where['userObj'] = $userObj['user_name'];
        if($replyTime != "") $where['replyTime'] = array('like','%'.$replyTime.'%');
        $replyRs = ReplyModel::where($where)->select();
        return $replyRs;
    }

    /*查询所有帖子回复记录*/
    public function queryAllReply(){
        $replyRs = ReplyModel::where(null)->select();
        return $replyRs;

    }

}
