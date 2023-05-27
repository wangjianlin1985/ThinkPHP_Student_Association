<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\YxzyModel;
use app\common\model\ShetuanModel;

class Shetuan extends BackBase {
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
    public function add(){
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
            return view('shetuan/shetuan_add');
        }
    }

    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("shetuanId",input("shetuanId"));
        return view("shetuan/shetuan_modify");
    }

    /*ajax方式按照查询条件分页查询社团信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->shetuanModel->setRows($this->request->param("rows"));
            $shetuanName = input("shetuanName")==null?"":input("shetuanName");
            $yxzyObj["yxzyId"] = input("yxzyObj_yxzyId")==null?0:input("yxzyObj_yxzyId");
            $bornDate = input("bornDate")==null?"":input("bornDate");
            $telephone = input("telephone")==null?"":input("telephone");
            $shetuanRs = $this->shetuanModel->queryShetuan($shetuanName, $yxzyObj, $bornDate, $telephone, $this->currentPage);
            $expTableData = [];
            foreach($shetuanRs as $shetuanRow) {
                $shetuanRow["yxzyObj"] = $this->yxzyModel->getYxzy($shetuanRow["yxzyObj"])["yxzyName"];
                $expTableData[] = $shetuanRow;
            }
            $data["rows"] = $shetuanRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->shetuanModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("shetuan/shetuan_query");
        }
    }

    /*ajax方式查询社团信息*/
    public function listAll() {
        $shetuanRs = $this->shetuanModel->queryAllShetuan();
        echo json_encode($shetuanRs);
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

    /*按照查询条件导出社团信息到Excel*/
    public function outToExcel() {
        $shetuanName = input("shetuanName")==null?"":input("shetuanName");
        $yxzyObj["yxzyId"] = input("yxzyObj_yxzyId")==null?0:input("yxzyObj_yxzyId");
        $bornDate = input("bornDate")==null?"":input("bornDate");
        $telephone = input("telephone")==null?"":input("telephone");
        $shetuanRs = $this->shetuanModel->queryOutputShetuan($shetuanName,$yxzyObj,$bornDate,$telephone);
        $expTableData = [];
        foreach($shetuanRs as $shetuanRow) {
            $shetuanRow["yxzyObj"] = $this->yxzyModel->getYxzy($shetuanRow["yxzyObj"])["yxzyName"];
            $expTableData[] = $shetuanRow;
        }
        $xlsName = "Shetuan";
        $xlsCell = array(
            array('shetuanId','社团id','int'),
            array('shetuanName','社团名称','string'),
            array('shetuanPhoto','社团图片','photo'),
            array('yxzyObj','所在院系专业','string'),
            array('bornDate','成立日期','string'),
            array('fuzeren','负责人','string'),
            array('telephone','联系电话','string'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

