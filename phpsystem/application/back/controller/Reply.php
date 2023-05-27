<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\PostInfoModel;
use app\common\model\UserInfoModel;
use app\common\model\ReplyModel;

class Reply extends BackBase {
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
    public function add(){
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
            return view('reply/reply_add');
        }
    }

    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("replyId",input("replyId"));
        return view("reply/reply_modify");
    }

    /*ajax方式按照查询条件分页查询帖子回复信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->replyModel->setRows($this->request->param("rows"));
            $postInfoObj["postInfoId"] = input("postInfoObj_postInfoId")==null?0:input("postInfoObj_postInfoId");
            $userObj["user_name"] = input("userObj_user_name")==null?"":input("userObj_user_name");
            $replyTime = input("replyTime")==null?"":input("replyTime");
            $replyRs = $this->replyModel->queryReply($postInfoObj, $userObj, $replyTime, $this->currentPage);
            $expTableData = [];
            foreach($replyRs as $replyRow) {
                $replyRow["postInfoObj"] = $this->postInfoModel->getPostInfo($replyRow["postInfoObj"])["title"];
                $replyRow["userObj"] = $this->userInfoModel->getUserInfo($replyRow["userObj"])["name"];
                $expTableData[] = $replyRow;
            }
            $data["rows"] = $replyRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->replyModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("reply/reply_query");
        }
    }

    /*ajax方式查询帖子回复信息*/
    public function listAll() {
        $replyRs = $this->replyModel->queryAllReply();
        echo json_encode($replyRs);
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

    /*按照查询条件导出帖子回复信息到Excel*/
    public function outToExcel() {
        $postInfoObj["postInfoId"] = input("postInfoObj_postInfoId")==null?0:input("postInfoObj_postInfoId");
        $userObj["user_name"] = input("userObj_user_name")==null?"":input("userObj_user_name");
        $replyTime = input("replyTime")==null?"":input("replyTime");
        $replyRs = $this->replyModel->queryOutputReply($postInfoObj,$userObj,$replyTime);
        $expTableData = [];
        foreach($replyRs as $replyRow) {
            $replyRow["postInfoObj"] = $this->postInfoModel->getPostInfo($replyRow["postInfoObj"])["title"];
            $replyRow["userObj"] = $this->userInfoModel->getUserInfo($replyRow["userObj"])["name"];
            $expTableData[] = $replyRow;
        }
        $xlsName = "Reply";
        $xlsCell = array(
            array('replyId','回复id','int'),
            array('postInfoObj','被回帖子','string'),
            array('content','回复内容','string'),
            array('userObj','回复人','string'),
            array('replyTime','回复时间','string'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

