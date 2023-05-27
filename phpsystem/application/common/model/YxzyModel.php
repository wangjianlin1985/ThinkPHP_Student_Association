<?php
namespace app\common\model;
use think\Model;

class YxzyModel extends Model {
    /*关联表名*/
    protected $table  = 't_yxzy';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    /*添加院系专业记录*/
    public function addYxzy($yxzy) {
        $this->insert($yxzy);
    }

    /*更新院系专业记录*/
    public function updateYxzy($yxzy) {
        $this->update($yxzy);
    }

    /*删除多条院系专业信息*/
    public function deleteYxzys($yxzyIds){
        $yxzyIdArray = explode(",",$yxzyIds);
        foreach ($yxzyIdArray as $yxzyId) {
            $this->yxzyId = $yxzyId;
            $this->delete();
        }
        return count($yxzyIdArray);
    }
    /*根据主键获取院系专业记录*/
    public function getYxzy($yxzyId) {
        $yxzy = YxzyModel::where("yxzyId",$yxzyId)->find();
        return $yxzy;
    }

    /*按照查询条件分页查询院系专业信息*/
    public function queryYxzy($currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        $yxzyRs = YxzyModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = YxzyModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $yxzyRs;
    }

    /*按照查询条件查询所有院系专业记录*/
  public function queryOutputYxzy() {
        $where = null;
        $yxzyRs = YxzyModel::where($where)->select();
        return $yxzyRs;
    }

    /*查询所有院系专业记录*/
    public function queryAllYxzy(){
        $yxzyRs = YxzyModel::where(null)->select();
        return $yxzyRs;

    }

}
