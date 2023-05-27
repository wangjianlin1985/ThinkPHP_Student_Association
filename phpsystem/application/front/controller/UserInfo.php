<?php
namespace app\front\controller;
use think\Request;
use think\Exception;
use app\common\model\UserInfoModel;

class UserInfo extends Base {
    protected $userInfoModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->userInfoModel = new UserInfoModel();
    }

    /*添加用户信息*/
    public function frontAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $userInfo = $this->getUserInfoForm(true);
            $this->uploadPhoto($userInfo,"userPhoto","userPhotoFile"); //处理用户照片上传
            $userInfo["regTime"] = date('Y-m-d H:i:s');
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
            return $this->fetch('userInfo/userInfo_frontAdd');
        }
    }

    /*前台修改用户信息*/
    public function frontModify() {
        $this->assign("user_name",input("user_name"));
        return $this->fetch("userInfo/userInfo_frontModify");
    }

    /*前台修改用户信息*/
    public function frontSelfModify() {
        $this->assign("user_name",session("user_name"));
        return $this->fetch("userInfo/userInfo_frontModify");
    }

    /*前台按照查询条件分页查询用户信息*/
    public function frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $user_name = input("user_name")==null?"":input("user_name");
        $name = input("name")==null?"":input("name");
        $birthDate = input("birthDate")==null?"":input("birthDate");
        $telephone = input("telephone")==null?"":input("telephone");
        $userInfoRs = $this->userInfoModel->queryUserInfo($user_name, $name, $birthDate, $telephone, $this->currentPage);
        $this->assign("userInfoRs",$userInfoRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->userInfoModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->userInfoModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->userInfoModel->rows);
        $this->assign("user_name",$user_name);
        $this->assign("name",$name);
        $this->assign("birthDate",$birthDate);
        $this->assign("telephone",$telephone);
        return $this->fetch('userInfo/userInfo_frontlist');
    }

    /*ajax方式查询用户信息*/
    public function listAll() {
        $userInfoRs = $this->userInfoModel->queryAllUserInfo();
        echo json_encode($userInfoRs);
    }
    /*前台查询根据主键查询一条用户信息*/
    public function frontshow() {
        $user_name = input("user_name");
        $userInfo = $this->userInfoModel->getUserInfo($user_name);
       $this->assign("userInfo",$userInfo);
        return $this->fetch("userInfo/userInfo_frontshow");
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

}

