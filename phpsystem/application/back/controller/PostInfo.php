<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\UserInfoModel;
use app\common\model\PostInfoModel;

class PostInfo extends BackBase {
    protected $userInfoModel;
    protected $postInfoModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->userInfoModel = new UserInfoModel();
        $this->postInfoModel = new PostInfoModel();
    }

    /*添加帖子信息*/
    public function add(){
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
            return view('postInfo/postInfo_add');
        }
    }

    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("postInfoId",input("postInfoId"));
        return view("postInfo/postInfo_modify");
    }

    /*ajax方式按照查询条件分页查询帖子信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->postInfoModel->setRows($this->request->param("rows"));
            $title = input("title")==null?"":input("title");
            $userObj["user_name"] = input("userObj_user_name")==null?"":input("userObj_user_name");
            $addTime = input("addTime")==null?"":input("addTime");
            $postInfoRs = $this->postInfoModel->queryPostInfo($title, $userObj, $addTime, $this->currentPage);
            $expTableData = [];
            foreach($postInfoRs as $postInfoRow) {
                $postInfoRow["userObj"] = $this->userInfoModel->getUserInfo($postInfoRow["userObj"])["name"];
                $expTableData[] = $postInfoRow;
            }
            $data["rows"] = $postInfoRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->postInfoModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("postInfo/postInfo_query");
        }
    }

    /*ajax方式查询帖子信息*/
    public function listAll() {
        $postInfoRs = $this->postInfoModel->queryAllPostInfo();
        echo json_encode($postInfoRs);
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

    /*按照查询条件导出帖子信息到Excel*/
    public function outToExcel() {
        $title = input("title")==null?"":input("title");
        $userObj["user_name"] = input("userObj_user_name")==null?"":input("userObj_user_name");
        $addTime = input("addTime")==null?"":input("addTime");
        $postInfoRs = $this->postInfoModel->queryOutputPostInfo($title,$userObj,$addTime);
        $expTableData = [];
        foreach($postInfoRs as $postInfoRow) {
            $postInfoRow["userObj"] = $this->userInfoModel->getUserInfo($postInfoRow["userObj"])["name"];
            $expTableData[] = $postInfoRow;
        }
        $xlsName = "PostInfo";
        $xlsCell = array(
            array('postInfoId','帖子id','int'),
            array('title','帖子标题','string'),
            array('hitNum','浏览量','int'),
            array('userObj','发帖人','string'),
            array('addTime','发帖时间','string'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

