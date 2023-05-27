<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\YxzyModel;

class Yxzy extends BackBase {
    protected $yxzyModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->yxzyModel = new YxzyModel();
    }

    /*添加院系专业信息*/
    public function add(){
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
            return view('yxzy/yxzy_add');
        }
    }

    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("yxzyId",input("yxzyId"));
        return view("yxzy/yxzy_modify");
    }

    /*ajax方式按照查询条件分页查询院系专业信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->yxzyModel->setRows($this->request->param("rows"));
            $yxzyRs = $this->yxzyModel->queryYxzy($this->currentPage);
            $expTableData = [];
            foreach($yxzyRs as $yxzyRow) {
                $expTableData[] = $yxzyRow;
            }
            $data["rows"] = $yxzyRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->yxzyModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("yxzy/yxzy_query");
        }
    }

    /*ajax方式查询院系专业信息*/
    public function listAll() {
        $yxzyRs = $this->yxzyModel->queryAllYxzy();
        echo json_encode($yxzyRs);
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

    /*按照查询条件导出院系专业信息到Excel*/
    public function outToExcel() {
        $yxzyRs = $this->yxzyModel->queryOutputYxzy();
        $expTableData = [];
        foreach($yxzyRs as $yxzyRow) {
            $expTableData[] = $yxzyRow;
        }
        $xlsName = "Yxzy";
        $xlsCell = array(
            array('yxzyId','院系专业id','int'),
            array('yxzyName','院系专业名称','string'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

