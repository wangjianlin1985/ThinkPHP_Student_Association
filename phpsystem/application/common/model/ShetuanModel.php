<?php
namespace app\common\model;
use think\Model;

class ShetuanModel extends Model {
    /*关联表名*/
    protected $table  = 't_shetuan';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    //所在院系专业复合属性的获取: 多对一关系
    public function yxzyObjF(){
        return $this->belongsTo('YxzyModel','yxzyObj');
    }

    /*添加社团记录*/
    public function addShetuan($shetuan) {
        $this->insert($shetuan);
    }

    /*更新社团记录*/
    public function updateShetuan($shetuan) {
        $this->update($shetuan);
    }

    /*删除多条社团信息*/
    public function deleteShetuans($shetuanIds){
        $shetuanIdArray = explode(",",$shetuanIds);
        foreach ($shetuanIdArray as $shetuanId) {
            $this->shetuanId = $shetuanId;
            $this->delete();
        }
        return count($shetuanIdArray);
    }
    /*根据主键获取社团记录*/
    public function getShetuan($shetuanId) {
        $shetuan = ShetuanModel::where("shetuanId",$shetuanId)->find();
        return $shetuan;
    }

    /*按照查询条件分页查询社团信息*/
    public function queryShetuan($shetuanName, $yxzyObj, $bornDate, $telephone, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($shetuanName != "") $where['shetuanName'] = array('like','%'.$shetuanName.'%');
        if($yxzyObj['yxzyId'] != 0) $where['yxzyObj'] = $yxzyObj['yxzyId'];
        if($bornDate != "") $where['bornDate'] = array('like','%'.$bornDate.'%');
        if($telephone != "") $where['telephone'] = array('like','%'.$telephone.'%');
        $shetuanRs = ShetuanModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = ShetuanModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $shetuanRs;
    }

    /*按照查询条件查询所有社团记录*/
  public function queryOutputShetuan( $shetuanName,  $yxzyObj,  $bornDate,  $telephone) {
        $where = null;
        if($shetuanName != "") $where['shetuanName'] = array('like','%'.$shetuanName.'%');
        if($yxzyObj['yxzyId'] != 0) $where['yxzyObj'] = $yxzyObj['yxzyId'];
        if($bornDate != "") $where['bornDate'] = array('like','%'.$bornDate.'%');
        if($telephone != "") $where['telephone'] = array('like','%'.$telephone.'%');
        $shetuanRs = ShetuanModel::where($where)->select();
        return $shetuanRs;
    }

    /*查询所有社团记录*/
    public function queryAllShetuan(){
        $shetuanRs = ShetuanModel::where(null)->select();
        return $shetuanRs;

    }

}
