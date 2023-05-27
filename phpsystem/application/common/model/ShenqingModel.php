<?php
namespace app\common\model;
use think\Model;

class ShenqingModel extends Model {
    /*关联表名*/
    protected $table  = 't_shenqing';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    //申请的社团复合属性的获取: 多对一关系
    public function shetuanObjF(){
        return $this->belongsTo('ShetuanModel','shetuanObj');
    }

    //申请用户复合属性的获取: 多对一关系
    public function userObjF(){
        return $this->belongsTo('UserInfoModel','userObj');
    }

    /*添加社团申请记录*/
    public function addShenqing($shenqing) {
        $this->insert($shenqing);
    }

    /*更新社团申请记录*/
    public function updateShenqing($shenqing) {
        $this->update($shenqing);
    }

    /*删除多条社团申请信息*/
    public function deleteShenqings($shenqingIds){
        $shenqingIdArray = explode(",",$shenqingIds);
        foreach ($shenqingIdArray as $shenqingId) {
            $this->shenqingId = $shenqingId;
            $this->delete();
        }
        return count($shenqingIdArray);
    }
    /*根据主键获取社团申请记录*/
    public function getShenqing($shenqingId) {
        $shenqing = ShenqingModel::where("shenqingId",$shenqingId)->find();
        return $shenqing;
    }

    /*按照查询条件分页查询社团申请信息*/
    public function queryShenqing($shetuanObj, $userObj, $shenqingTime, $shenHe, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($shetuanObj['shetuanId'] != 0) $where['shetuanObj'] = $shetuanObj['shetuanId'];
        if($userObj['user_name'] != "") $where['userObj'] = $userObj['user_name'];
        if($shenqingTime != "") $where['shenqingTime'] = array('like','%'.$shenqingTime.'%');
        if($shenHe != "") $where['shenHe'] = array('like','%'.$shenHe.'%');
        $shenqingRs = ShenqingModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = ShenqingModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $shenqingRs;
    }

    /*按照查询条件查询所有社团申请记录*/
  public function queryOutputShenqing( $shetuanObj,  $userObj,  $shenqingTime,  $shenHe) {
        $where = null;
        if($shetuanObj['shetuanId'] != 0) $where['shetuanObj'] = $shetuanObj['shetuanId'];
        if($userObj['user_name'] != "") $where['userObj'] = $userObj['user_name'];
        if($shenqingTime != "") $where['shenqingTime'] = array('like','%'.$shenqingTime.'%');
        if($shenHe != "") $where['shenHe'] = array('like','%'.$shenHe.'%');
        $shenqingRs = ShenqingModel::where($where)->select();
        return $shenqingRs;
    }

    /*查询所有社团申请记录*/
    public function queryAllShenqing(){
        $shenqingRs = ShenqingModel::where(null)->select();
        return $shenqingRs;

    }

}
