<?php
namespace app\front\controller;
use think\Request;
use think\Exception;
use app\common\model\PostInfoModel;
use app\common\model\UserInfoModel;
use app\common\model\ReplyModel;

class Reply extends Base {
    protected $postInfoModel;
    protected $userInfoModel;
    protected $replyModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->postInfoModel = new PostInfoModel();
        $this->userInfoModel = new UserInfoModel();
        $this->replyModel = new ReplyModel();
    }

    /*添加帖子回复信息*/
    public function frontAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $reply = $this->getReplyForm(true);
            try {
                $this->replyModel->addReply($reply);
                $message = "帖子回复添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "帖子回复添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return $this->fetch('reply/reply_frontAdd');
        }
    }


    /*前台用户添加帖子回复信息*/
    public function frontUserAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            if(session("user_name") == null) {
                $message = "请先登录网站!";
                $this->writeJsonResponse($success,$message);
                return;
            }
            $reply = $this->getReplyForm(true);
            $reply["userObj"] = session("user_name");
            $reply["replyTime"] = date('Y-m-d H:i:s');
            try {
                $this->replyModel->addReply($reply);
                $message = "帖子回复添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "帖子回复添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return $this->fetch('reply/reply_frontUserAdd');
        }
    }



    /*前台修改帖子回复信息*/
    public function frontModify() {
        $this->assign("replyId",input("replyId"));
        return $this->fetch("reply/reply_frontModify");
    }

    /*前台按照查询条件分页查询帖子回复信息*/
    public function frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $postInfoObj["postInfoId"] = input("postInfoObj_postInfoId")==null?0:input("postInfoObj_postInfoId");
        $userObj["user_name"] = input("userObj_user_name")==null?"":input("userObj_user_name");
        $replyTime = input("replyTime")==null?"":input("replyTime");
        $replyRs = $this->replyModel->queryReply($postInfoObj, $userObj, $replyTime, $this->currentPage);
        $this->assign("replyRs",$replyRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->replyModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->replyModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->replyModel->rows);
        $this->assign("postInfoObj",$postInfoObj);
        $this->assign("postInfoList",$this->postInfoModel->queryAllPostInfo());
        $this->assign("userObj",$userObj);
        $this->assign("userInfoList",$this->userInfoModel->queryAllUserInfo());
        $this->assign("replyTime",$replyTime);
        return $this->fetch('reply/reply_frontlist');
    }

    /*ajax方式查询帖子回复信息*/
    public function listAll() {
        $replyRs = $this->replyModel->queryAllReply();
        echo json_encode($replyRs);
    }
    /*前台查询根据主键查询一条帖子回复信息*/
    public function frontshow() {
        $replyId = input("replyId");
        $reply = $this->replyModel->getReply($replyId);
       $this->assign("reply",$reply);
        return $this->fetch("reply/reply_frontshow");
    }

    /*更新帖子回复信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $reply = $this->getReplyForm(false);
            try {
                $this->replyModel->updateReply($reply);
                $message = "帖子回复更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "帖子回复更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取帖子回复对象*/
            $replyId = input("replyId");
            $reply = $this->replyModel->getReply($replyId);
            echo json_encode($reply);
        }
    }

    /*删除多条帖子回复记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $replyIds = input("replyIds");
        try {
            $count = $this->replyModel->deleteReplys($replyIds);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

}

