<?php
namespace app\front\controller;

class Index extends Base
{
    /*前台首页*/
    public function index() {
        return $this->fetch();
    }

    /*前台用户登录处理*/
    public function frontLogin() {
        $success = false;
		$message = "";
        $username = input("userName");
        $password = input("password");
        $userInfo = db('userinfo')->find($username);//查询数据库
        if($userInfo && $userInfo["password"] == $password) {
            $success = true;
            session("user_name",$username);
            $this->writeJsonResponse($success,$message);
        } else {
            $message = "用户名或密码错误！";
            $this->writeJsonResponse($success,$message);
            return;
        }
    }

    /*前台用户退出*/
    public function logout() {
        session("user_name",null);
        $this->success("退出成功","Index/index");
    }
}
?>