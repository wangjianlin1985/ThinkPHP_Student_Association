<?php
namespace app\front\controller;
use think\Request;
use think\Exception;
use app\common\model\YxzyModel;

class Yxzy extends Base {
    protected $yxzyModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->yxzyModel = new YxzyModel();
    }

    /*添加院系专业信息*/
    public function frontAdd(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $yxzy = $this->getYxzyForm(true);
            try {
                $this->yxzyModel->addYxzy($yxzy);
                $message = "院系专业添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "院系专业添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return $this->fetch('yxzy/yxzy_frontAdd');
        }
    }

    /*前台修改院系专业信息*/
    public function frontModify() {
        $this->assign("yxzyId",input("yxzyId"));
        return $this->fetch("yxzy/yxzy_frontModify");
    }

    /*前台按照查询条件分页查询院系专业信息*/
    public function frontlist() {
        if($this->request->param("currentPage") != null)
            $this->currentPage = $this->request->param("currentPage");
        $yxzyRs = $this->yxzyModel->queryYxzy($this->currentPage);
        $this->assign("yxzyRs",$yxzyRs);
        /*获取到总的页码数目*/
        $this->assign("totalPage",$this->yxzyModel->totalPage);
        /*当前查询条件下总记录数*/
        $this->assign("recordNumber",$this->yxzyModel->recordNumber);
        $this->assign("currentPage",$this->currentPage);
        $this->assign("rows",$this->yxzyModel->rows);
        return $this->fetch('yxzy/yxzy_frontlist');
    }

    /*ajax方式查询院系专业信息*/
    public function listAll() {
        $yxzyRs = $this->yxzyModel->queryAllYxzy();
        echo json_encode($yxzyRs);
    }
    /*前台查询根据主键查询一条院系专业信息*/
    public function frontshow() {
        $yxzyId = input("yxzyId");
        $yxzy = $this->yxzyModel->getYxzy($yxzyId);
       $this->assign("yxzy",$yxzy);
        return $this->fetch("yxzy/yxzy_frontshow");
    }

    /*更新院系专业信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $yxzy = $this->getYxzyForm(false);
            try {
                $this->yxzyModel->updateYxzy($yxzy);
                $message = "院系专业更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "院系专业更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取院系专业对象*/
            $yxzyId = input("yxzyId");
            $yxzy = $this->yxzyModel->getYxzy($yxzyId);
            echo json_encode($yxzy);
        }
    }

    /*删除多条院系专业记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $yxzyIds = input("yxzyIds");
        try {
            $count = $this->yxzyModel->deleteYxzys($yxzyIds);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

}

