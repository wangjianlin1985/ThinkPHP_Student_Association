<?php
namespace app\front\controller;
use think\Request;
use think\Exception;
use app\common\model\YxzyModel;
use app\common\model\ShetuanModel;

class Shetuan extends Base {
    protected $yxzyModel;
    protected $shetuanModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->yxzyModel = new YxzyModel();
        $this->shetuanModel = new ShetuanModel();
    }

    /*添加社团信息*/
    public function frontAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $shetuan = $this->getShetuanForm(true);
            $this->uploadPhoto($shetuan,"shetuanPhoto","shetuanPhotoFile"); //处理社团图片上传
            try {
                $this->shetuanModel->addShetuan($shetuan);
                $message = "社团添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "社团添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return $this->fetch('shetuan/shetuan_frontAdd');
        }
    }

    /*前台修改社团信息*/
    public function frontModify() {
        $this->assign("shetuanId",input("shetuanId"));
        return $this->fetch("shetuan/shetuan_frontModify");
    }

    /*前台按照查询条件分页查询社团信息*/
    public function frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $shetuanName = input("shetuanName")==null?"":input("shetuanName");
        $yxzyObj["yxzyId"] = input("yxzyObj_yxzyId")==null?0:input("yxzyObj_yxzyId");
        $bornDate = input("bornDate")==null?"":input("bornDate");
        $telephone = input("telephone")==null?"":input("telephone");
        $shetuanRs = $this->shetuanModel->queryShetuan($shetuanName, $yxzyObj, $bornDate, $telephone, $this->currentPage);
        $this->assign("shetuanRs",$shetuanRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->shetuanModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->shetuanModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->shetuanModel->rows);
        $this->assign("shetuanName",$shetuanName);
        $this->assign("yxzyObj",$yxzyObj);
        $this->assign("yxzyList",$this->yxzyModel->queryAllYxzy());
        $this->assign("bornDate",$bornDate);
        $this->assign("telephone",$telephone);
        return $this->fetch('shetuan/shetuan_frontlist');
    }

    /*ajax方式查询社团信息*/
    public function listAll() {
        $shetuanRs = $this->shetuanModel->queryAllShetuan();
        echo json_encode($shetuanRs);
    }
    /*前台查询根据主键查询一条社团信息*/
    public function frontshow() {
        $shetuanId = input("shetuanId");
        $shetuan = $this->shetuanModel->getShetuan($shetuanId);
       $this->assign("shetuan",$shetuan);
        return $this->fetch("shetuan/shetuan_frontshow");
    }

    /*更新社团信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $shetuan = $this->getShetuanForm(false);
            $this->uploadPhoto($shetuan,"shetuanPhoto","shetuanPhotoFile"); //处理社团图片上传
            try {
                $this->shetuanModel->updateShetuan($shetuan);
                $message = "社团更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "社团更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取社团对象*/
            $shetuanId = input("shetuanId");
            $shetuan = $this->shetuanModel->getShetuan($shetuanId);
            echo json_encode($shetuan);
        }
    }

    /*删除多条社团记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $shetuanIds = input("shetuanIds");
        try {
            $count = $this->shetuanModel->deleteShetuans($shetuanIds);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

}

