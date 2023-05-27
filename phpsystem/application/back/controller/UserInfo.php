<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\UserInfoModel;

class UserInfo extends BackBase {
    protected $userInfoModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->userInfoModel = new UserInfoModel();
    }

    /*添加用户信息*/
    public function add(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $userInfo = $this->getUserInfoForm(true);
            $this->uploadPhoto($userInfo,"userPhoto","userPhotoFile"); //处理用户照片上传
            try {
                $this->userInfoModel->addUserInfo($userInfo);
                $message = "用户添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "用户添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return view('userInfo/userInfo_add');
        }
    }

    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("user_name",input("user_name"));
        return view("userInfo/userInfo_modify");
    }

    /*ajax方式按照查询条件分页查询用户信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->userInfoModel->setRows($this->request->param("rows"));
            $user_name = input("user_name")==null?"":input("user_name");
            $name = input("name")==null?"":input("name");
            $birthDate = input("birthDate")==null?"":input("birthDate");
            $telephone = input("telephone")==null?"":input("telephone");
            $userInfoRs = $this->userInfoModel->queryUserInfo($user_name, $name, $birthDate, $telephone, $this->currentPage);
            $expTableData = [];
            foreach($userInfoRs as $userInfoRow) {
                $expTableData[] = $userInfoRow;
            }
            $data["rows"] = $userInfoRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->userInfoModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("userInfo/userInfo_query");
        }
    }

    /*ajax方式查询用户信息*/
    public function listAll() {
        $userInfoRs = $this->userInfoModel->queryAllUserInfo();
        echo json_encode($userInfoRs);
    }
    /*更新用户信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $userInfo = $this->getUserInfoForm(false);
            $this->uploadPhoto($userInfo,"userPhoto","userPhotoFile"); //处理用户照片上传
            try {
                $this->userInfoModel->updateUserInfo($userInfo);
                $message = "用户更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "用户更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取用户对象*/
            $user_name = input("user_name");
            $userInfo = $this->userInfoModel->getUserInfo($user_name);
            echo json_encode($userInfo);
        }
    }

    /*删除多条用户记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $user_names = input("user_names");
        try {
            $count = $this->userInfoModel->deleteUserInfos($user_names);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

    /*按照查询条件导出用户信息到Excel*/
    public function outToExcel() {
        $user_name = input("user_name")==null?"":input("user_name");
        $name = input("name")==null?"":input("name");
        $birthDate = input("birthDate")==null?"":input("birthDate");
        $telephone = input("telephone")==null?"":input("telephone");
        $userInfoRs = $this->userInfoModel->queryOutputUserInfo($user_name,$name,$birthDate,$telephone);
        $expTableData = [];
        foreach($userInfoRs as $userInfoRow) {
            $expTableData[] = $userInfoRow;
        }
        $xlsName = "UserInfo";
        $xlsCell = array(
            array('user_name','用户名','string'),
            array('name','姓名','string'),
            array('gender','性别','string'),
            array('birthDate','出生日期','string'),
            array('userPhoto','用户照片','photo'),
            array('telephone','联系电话','string'),
            array('email','邮箱','string'),
            array('regTime','注册时间','string'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

