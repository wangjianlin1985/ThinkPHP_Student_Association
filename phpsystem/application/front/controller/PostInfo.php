<?php
namespace app\front\controller;
use app\common\model\ReplyModel;
use think\Request;
use think\Exception;
use app\common\model\UserInfoModel;
use app\common\model\PostInfoModel;

class PostInfo extends Base {
    protected $userInfoModel;
    protected $postInfoModel;
    protected $replyModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->userInfoModel = new UserInfoModel();
        $this->postInfoModel = new PostInfoModel();
        $this->replyModel = new ReplyModel();
    }

    /*添加帖子信息*/
    public function frontAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $postInfo = $this->getPostInfoForm(true);
            try {
                $this->postInfoModel->addPostInfo($postInfo);
                $message = "帖子添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "帖子添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return $this->fetch('postInfo/postInfo_frontAdd');
        }
    }

    /*添加帖子信息*/
    public function frontUserAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $postInfo = $this->getPostInfoForm(true);
            $postInfo["userObj"] = session("user_name");
            $postInfo["addTime"] =  date('Y-m-d H:i:s');
            try {
                $this->postInfoModel->addPostInfo($postInfo);
                $message = "帖子添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "帖子添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return $this->fetch('postInfo/postInfo_frontUserAdd');
        }
    }


    /*前台修改帖子信息*/
    public function frontModify() {
        $this->assign("postInfoId",input("postInfoId"));
        return $this->fetch("postInfo/postInfo_frontModify");
    }

    /*前台按照查询条件分页查询帖子信息*/
    public function frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $title = input("title")==null?"":input("title");
        $userObj["user_name"] = input("userObj_user_name")==null?"":input("userObj_user_name");
        $addTime = input("addTime")==null?"":input("addTime");
        $postInfoRs = $this->postInfoModel->queryPostInfo($title, $userObj, $addTime, $this->currentPage);
        $this->assign("postInfoRs",$postInfoRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->postInfoModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->postInfoModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->postInfoModel->rows);
        $this->assign("title",$title);
        $this->assign("userObj",$userObj);
        $this->assign("userInfoList",$this->userInfoModel->queryAllUserInfo());
        $this->assign("addTime",$addTime);
        return $this->fetch('postInfo/postInfo_frontlist');
    }


    /*前台按照查询条件分页查询帖子信息*/
    public function user_frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $title = input("title")==null?"":input("title");
        $userObj["user_name"] = session("user_name");
        $addTime = input("addTime")==null?"":input("addTime");
        $postInfoRs = $this->postInfoModel->queryPostInfo($title, $userObj, $addTime, $this->currentPage);
        $this->assign("postInfoRs",$postInfoRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->postInfoModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->postInfoModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->postInfoModel->rows);
        $this->assign("title",$title);
        $this->assign("userObj",$userObj);
        $this->assign("userInfoList",$this->userInfoModel->queryAllUserInfo());
        $this->assign("addTime",$addTime);
        return $this->fetch('postInfo/postInfo_user_frontlist');
    }


    /*ajax方式查询帖子信息*/
    public function listAll() {
        $postInfoRs = $this->postInfoModel->queryAllPostInfo();
        echo json_encode($postInfoRs);
    }
    /*前台查询根据主键查询一条帖子信息*/
    public function frontshow() {
        $postInfoId = input("postInfoId");
        $this->postInfoModel->setIncViewNum($postInfoId);
        $postInfo = $this->postInfoModel->getPostInfo($postInfoId);
        $this->assign("postInfo",$postInfo);
        $postInfoObj['postInfoId'] = $postInfo->postInfoId;
        $replyList = $this->replyModel->queryOutputReply($postInfoObj,null,"");
        $this->assign("replyList",$replyList);
        return $this->fetch("postInfo/postInfo_frontshow");
    }

    /*更新帖子信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $postInfo = $this->getPostInfoForm(false);
            try {
                $this->postInfoModel->updatePostInfo($postInfo);
                $message = "帖子更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "帖子更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取帖子对象*/
            $postInfoId = input("postInfoId");
            $postInfo = $this->postInfoModel->getPostInfo($postInfoId);
            echo json_encode($postInfo);
        }
    }

    /*删除多条帖子记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $postInfoIds = input("postInfoIds");
        try {
            $count = $this->postInfoModel->deletePostInfos($postInfoIds);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

}

