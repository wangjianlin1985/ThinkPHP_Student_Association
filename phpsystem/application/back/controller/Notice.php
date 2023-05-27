<?php
namespace app\back\controller;
use think\Request;
use think\Exception;
use app\common\model\NoticeModel;

class Notice extends BackBase {
    protected $noticeModel;

    //控制层对象初始化：注入业务逻辑层对象等
    public function _initialize() {
        parent::_initialize();
        $this->request = Request::instance();
        $this->noticeModel = new NoticeModel();
    }

    /*添加新闻公告信息*/
    public function add(){
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $notice = $this->getNoticeForm(true);
            try {
                $this->noticeModel->addNotice($notice);
                $message = "新闻公告添加成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "新闻公告添加失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            return view('notice/notice_add');
        }
    }

    /*跳转到更新界面*/
    public function modifyView() {
        $this->assign("noticeId",input("noticeId"));
        return view("notice/notice_modify");
    }

    /*ajax方式按照查询条件分页查询新闻公告信息*/
    public function backList() {
        if($this->request->isPost()) {
            if($this->request->param("page") != null)
                $this->currentPage = $this->request->param("page");
            if($this->request->param("rows") != null)
                $this->noticeModel->setRows($this->request->param("rows"));
            $title = input("title")==null?"":input("title");
            $publishDate = input("publishDate")==null?"":input("publishDate");
            $noticeRs = $this->noticeModel->queryNotice($title, $publishDate, $this->currentPage);
            $expTableData = [];
            foreach($noticeRs as $noticeRow) {
                $expTableData[] = $noticeRow;
            }
            $data["rows"] = $noticeRs;
            /*当前查询条件下总记录数*/
            $data["total"] = $this->noticeModel->recordNumber;
            echo json_encode($data);
        } else {
            return view("notice/notice_query");
        }
    }

    /*ajax方式查询新闻公告信息*/
    public function listAll() {
        $noticeRs = $this->noticeModel->queryAllNotice();
        echo json_encode($noticeRs);
    }
    /*更新新闻公告信息*/
    public function update() {
        $message = "";
        $success = false;
        if($this->request->isPost()) {
            $notice = $this->getNoticeForm(false);
            try {
                $this->noticeModel->updateNotice($notice);
                $message = "新闻公告更新成功!";
                $success = true;
                $this->writeJsonResponse($success, $message);
            } catch (Exception $ex) {
                $message = "新闻公告更新失败!";
                $this->writeJsonResponse($success,$message);
            }
        } else {
            /*根据主键获取新闻公告对象*/
            $noticeId = input("noticeId");
            $notice = $this->noticeModel->getNotice($noticeId);
            echo json_encode($notice);
        }
    }

    /*删除多条新闻公告记录*/
    public function deletes() {
        $message = "";
        $success = false;
        $noticeIds = input("noticeIds");
        try {
            $count = $this->noticeModel->deleteNotices($noticeIds);
            $success = true;
            $message = $count."条记录删除成功";
            $this->writeJsonResponse($success, $message);
        } catch (Exception $ex) {
            $message = "有记录存在外键约束,删除失败";
            $this->writeJsonResponse($success, $message);
        }
    }

    /*按照查询条件导出新闻公告信息到Excel*/
    public function outToExcel() {
        $title = input("title")==null?"":input("title");
        $publishDate = input("publishDate")==null?"":input("publishDate");
        $noticeRs = $this->noticeModel->queryOutputNotice($title,$publishDate);
        $expTableData = [];
        foreach($noticeRs as $noticeRow) {
            $expTableData[] = $noticeRow;
        }
        $xlsName = "Notice";
        $xlsCell = array(
            array('noticeId','公告id','int'),
            array('title','标题','string'),
            array('publishDate','发布时间','string'),
        );//查出字段输出对应Excel对应的列名
        //公共方法调用
        $this->export_excel($xlsName,$xlsCell,$expTableData);
    }

}

