<?php
namespace app\common\model;
use think\Model;

class NoticeModel extends Model {
    /*关联表名*/
    protected $table  = 't_notice';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    /*添加新闻公告记录*/
    public function addNotice($notice) {
        $this->insert($notice);
    }

    /*更新新闻公告记录*/
    public function updateNotice($notice) {
        $this->update($notice);
    }

    /*删除多条新闻公告信息*/
    public function deleteNotices($noticeIds){
        $noticeIdArray = explode(",",$noticeIds);
        foreach ($noticeIdArray as $noticeId) {
            $this->noticeId = $noticeId;
            $this->delete();
        }
        return count($noticeIdArray);
    }
    /*根据主键获取新闻公告记录*/
    public function getNotice($noticeId) {
        $notice = NoticeModel::where("noticeId",$noticeId)->find();
        return $notice;
    }

    /*按照查询条件分页查询新闻公告信息*/
    public function queryNotice($title, $publishDate, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($title != "") $where['title'] = array('like','%'.$title.'%');
        if($publishDate != "") $where['publishDate'] = array('like','%'.$publishDate.'%');
        $noticeRs = NoticeModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = NoticeModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $noticeRs;
    }

    /*按照查询条件查询所有新闻公告记录*/
  public function queryOutputNotice( $title,  $publishDate) {
        $where = null;
        if($title != "") $where['title'] = array('like','%'.$title.'%');
        if($publishDate != "") $where['publishDate'] = array('like','%'.$publishDate.'%');
        $noticeRs = NoticeModel::where($where)->select();
        return $noticeRs;
    }

    /*查询所有新闻公告记录*/
    public function queryAllNotice(){
        $noticeRs = NoticeModel::where(null)->select();
        return $noticeRs;

    }

}
