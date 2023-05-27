<?php
namespace app\front\controller;
use think\Request;
use think\Exception;
use app\common\model\NoticeModel;

class Notice extends Base {
    protected $noticeModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->noticeModel = new NoticeModel();
    }

    /*添加新闻公告信息*/
    public function frontAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $notice = $this->getNoticeForm(true);
            try {
                $this->noticeModel->addNotice($notice);
                $message = "新闻公告添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "新闻公告添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return $this->fetch('notice/notice_frontAdd');
        }
    }

    /*前台修改新闻公告信息*/
    public function frontModify() {
        $this->assign("noticeId",input("noticeId"));
        return $this->fetch("notice/notice_frontModify");
    }

    /*前台按照查询条件分页查询新闻公告信息*/
    public function frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $title = input("title")==null?"":input("title");
        $publishDate = input("publishDate")==null?"":input("publishDate");
        $noticeRs = $this->noticeModel->queryNotice($title, $publishDate, $this->currentPage);
        $this->assign("noticeRs",$noticeRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->noticeModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->noticeModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->noticeModel->rows);
        $this->assign("title",$title);
        $this->assign("publishDate",$publishDate);
        return $this->fetch('notice/notice_frontlist');
    }

    /*ajax方式查询新闻公告信息*/
    public function listAll() {
        $noticeRs = $this->noticeModel->queryAllNotice();
        echo json_encode($noticeRs);
    }
    /*前台查询根据主键查询一条新闻公告信息*/
    public function frontshow() {
        $noticeId = input("noticeId");
        $notice = $this->noticeModel->getNotice($noticeId);
       $this->assign("notice",$notice);
        return $this->fetch("notice/notice_frontshow");
    }

    /*更新新闻公告信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $notice = $this->getNoticeForm(false);
            try {
                $this->noticeModel->updateNotice($notice);
                $message = "新闻公告更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "新闻公告更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取新闻公告对象*/
            $noticeId = input("noticeId");
            $notice = $this->noticeModel->getNotice($noticeId);
            echo json_encode($notice);
        }
    }

    /*删除多条新闻公告记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $noticeIds = input("noticeIds");
        try {
            $count = $this->noticeModel->deleteNotices($noticeIds);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

}

