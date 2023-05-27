<?php
namespace app\back\controller;
use think\Controller;

class BackBase extends Controller
{
    protected $currentPage = 1;
    protected $request = null;

    public function _initialize(){
        if(!session('username')){
            $this->error('请先登录系统！','Login/index');
        }
    }

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

    /** * 公共数据导出实现功能
     * @param $expTitle 导出文件名
     * @param $expCellName 导出文件列名称
     * @param $expTableData 导出数据
     */
    public function export_excel($expTitle,$expCellName,$expTableData) {
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $expTitle . date('_Ymd');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        //这些文件需要下载phpexcel，然后放在vendor文件里面。具体参考上一篇数据导出。
        vendor("PHPExcel.PHPExcel");
        //vendor("PHPExcel.PHPExcel.Writer.IWriter");
        //vendor("PHPExcel.PHPExcel.Writer.Abstract");
        //vendor("PHPExcel.PHPExcel.Writer.Excel5");
        //vendor("PHPExcel.PHPExcel.Writer.Excel2007");
        vendor("PHPExcel.PHPExcel.IOFactory");
        $objPHPExcel = new \PHPExcel();//方法一
        $cellName = array('A','B', 'C','D', 'E', 'F','G','H','I', 'J', 'K','L','M', 'N', 'O', 'P', 'Q','R','S', 'T','U','V', 'W', 'X','Y', 'Z', 'AA',    'AB', 'AC','AD','AE', 'AF','AG','AH','AI', 'AJ', 'AK', 'AL','AM','AN','AO','AP','AQ','AR', 'AS', 'AT','AU', 'AV','AW', 'AX', 'AY', 'AZ');
        //设置头部导出时间备注
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1');//合并单元格
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle . ' 导出时间:' . date('Y-m-d H:i:s'));
        //设置列名称
        for ($i = 0; $i < $cellNum; $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $expCellName[$i][1]);
            $objPHPExcel->getActiveSheet()->getColumnDimension($cellName[$i])->setWidth(20); //设置每列宽度
            $objPHPExcel->getActiveSheet()->getStyle($cellName[$i].'2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle($cellName[$i])->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER); //垂直居中对齐
        }
        //赋值
        for ($i = 0; $i < $dataNum; $i++) {
            for ($j = 0; $j < $cellNum; $j++) {
                $objPHPExcel->getActiveSheet()->getStyle($cellName[$j].($i + 3))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                if($expCellName[$j][2] == 'photo') {
                    try {
                        // 表格高度
                        $objPHPExcel->getActiveSheet()->getRowDimension($i+3)->setRowHeight(80);
                        // 图片生成
                        $objDrawing = new \PHPExcel_Worksheet_Drawing();
                        $objDrawing->setPath(PUBLIC_PATH.$expTableData[$i][$expCellName[$j][0]]);
                        // 设置宽度高度
                        $objDrawing->setHeight(80);//照片高度
                        $objDrawing->setWidth(80); //照片宽度
                        /*设置图片要插入的单元格*/
                        $objDrawing->setCoordinates($cellName[$j].($i + 3));
                        // 图片偏移距离
                        $objDrawing->setOffsetX(5);
                        $objDrawing->setOffsetY(5);
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                    } catch (\Exception $ex) {}
                } else {
                    $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i + 3), $expTableData[$i][$expCellName[$j][0]]);
                }
            }
        }
        ob_end_clean();//这一步非常关键，用来清除缓冲区防止导出的excel乱码
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//"xls"参考下一条备注
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'  );//"Excel2007"生成2007版本的xlsx，"Excel5"生成2003版本的xls
        $objWriter->save('php://output');
    }
}

