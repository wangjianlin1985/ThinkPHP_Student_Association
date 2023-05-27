<?php
namespace app\front\controller;
use think\Controller;

class Base extends Controller
{
    protected $currentPage = 1;
    protected $request = null;

    //向客户端输出ajax响应结果
    public function writeJsonResponse($success, $message) {
        $response = array(
            "success" => $success,
            "message" => $message,
        );
        echo json_encode($response);
    }

    /**
     * @param $obj:  保存图片路径的对象
     * @param $indexName 索引名称
     * @param $photoFiledName 提交的图片表单名称
     */
    public function uploadPhoto(&$obj,$indexName,$photoFiledName) {
        if($_FILES[$photoFiledName]['tmp_name']){
            $file = $this->request->file($photoFiledName);
            //控制上传的文件类型，大小
            if(!(($_FILES[$photoFiledName]["type"]=="image/jpeg"
                    || $_FILES[$photoFiledName]["type"]=="image/jpg"
                    || $_FILES[$photoFiledName]["type"]=="image/png") && $_FILES[$photoFiledName]["size"] < 1024000)) {
                $message = "图书图片请选择jpg或png格式的图片!";
                $this->writeJsonResponse(false,$message);
                exit;
            }
            $file->setRule("short"); //文件路径采用简短方式
            $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
            $obj[$indexName]='upload/'.$info->getSaveName();
        }
    }

    /**
     * @param $obj:  保存文件路径的对象
     * @param $indexName 索引名称
     * @param $resourceFiledName 提交的文件表单名称
     */
    public function uploadFile(&$obj,$indexName,$resourceFiledName) {
        if($_FILES[$resourceFiledName]['tmp_name']){
            $file = $this->request->file($resourceFiledName);
            $file->setRule("short"); //文件路径采用简短方式
            $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
            $obj[$indexName]='upload/'.$info->getSaveName();
        }
    }

    //接收提交的UserInfo信息参数
    public function getUserInfoForm($insertFlag) {
        $userInfo = [
            'user_name'=> input("userInfo_user_name"), //用户名
            'password'=> input("userInfo_password"), //登录密码
            'name'=> input("userInfo_name"), //姓名
            'gender'=> input("userInfo_gender"), //性别
            'birthDate'=> input("userInfo_birthDate"), //出生日期
            'userPhoto' => $insertFlag==true?"upload/NoImage.jpg":input("userInfo_userPhoto"), //用户照片
            'telephone'=> input("userInfo_telephone"), //联系电话
            'email'=> input("userInfo_email"), //邮箱
            'address'=> input("userInfo_address"), //家庭地址
            'regTime'=> input("userInfo_regTime"), //注册时间
        ];
        return $userInfo;
    }

    //接收提交的Shetuan信息参数
    public function getShetuanForm($insertFlag) {
        $shetuan = [
            'shetuanId'=> input("shetuan_shetuanId"), //社团id
            'shetuanName'=> input("shetuan_shetuanName"), //社团名称
            'shetuanPhoto' => $insertFlag==true?"upload/NoImage.jpg":input("shetuan_shetuanPhoto"), //社团图片
            'yxzyObj'=> input("shetuan_yxzyObj_yxzyId"), //所在院系专业
            'bornDate'=> input("shetuan_bornDate"), //成立日期
            'shetuanDesc'=> input("shetuan_shetuanDesc"), //社团简介
            'fuzeren'=> input("shetuan_fuzeren"), //负责人
            'telephone'=> input("shetuan_telephone"), //联系电话
        ];
        return $shetuan;
    }

    //接收提交的Yxzy信息参数
    public function getYxzyForm($insertFlag) {
        $yxzy = [
            'yxzyId'=> input("yxzy_yxzyId"), //院系专业id
            'yxzyName'=> input("yxzy_yxzyName"), //院系专业名称
        ];
        return $yxzy;
    }

    //接收提交的Shenqing信息参数
    public function getShenqingForm($insertFlag) {
        $shenqing = [
            'shenqingId'=> input("shenqing_shenqingId"), //申请id
            'shetuanObj'=> input("shenqing_shetuanObj_shetuanId"), //申请的社团
            'userObj'=> input("shenqing_userObj_user_name"), //申请用户
            'shenqingTime'=> input("shenqing_shenqingTime"), //申请时间
            'shenHe'=> input("shenqing_shenHe"), //审核结果
            'shenqingMemo'=> input("shenqing_shenqingMemo"), //备注
        ];
        return $shenqing;
    }

    //接收提交的PostInfo信息参数
    public function getPostInfoForm($insertFlag) {
        $postInfo = [
            'postInfoId'=> input("postInfo_postInfoId"), //帖子id
            'title'=> input("postInfo_title"), //帖子标题
            'content'=> input("postInfo_content"), //帖子内容
            'hitNum'=> input("postInfo_hitNum"), //浏览量
            'userObj'=> input("postInfo_userObj_user_name"), //发帖人
            'addTime'=> input("postInfo_addTime"), //发帖时间
        ];
        return $postInfo;
    }

    //接收提交的Reply信息参数
    public function getReplyForm($insertFlag) {
        $reply = [
            'replyId'=> input("reply_replyId"), //回复id
            'postInfoObj'=> input("reply_postInfoObj_postInfoId"), //被回帖子
            'content'=> input("reply_content"), //回复内容
            'userObj'=> input("reply_userObj_user_name"), //回复人
            'replyTime'=> input("reply_replyTime"), //回复时间
        ];
        return $reply;
    }

    //接收提交的Notice信息参数
    public function getNoticeForm($insertFlag) {
        $notice = [
            'noticeId'=> input("notice_noticeId"), //公告id
            'title'=> input("notice_title"), //标题
            'content'=> input("notice_content"), //公告内容
            'publishDate'=> input("notice_publishDate"), //发布时间
        ];
        return $notice;
    }

}

