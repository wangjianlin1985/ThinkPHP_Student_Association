<?php
namespace app\common\model;
use think\Model;

class UserInfoModel extends Model {
    /*关联表名*/
    protected $table  = 't_userInfo';
    /*每页显示记录数目*/
    public $rows = 8;
    /*保存查询后总的页数*/
    public $totalPage;
    /*保存查询到的总记录数*/
    public $recordNumber;

    public function setRows($rows) {
        $this->rows = $rows;
    }

    /*添加用户记录*/
    public function addUserInfo($userInfo) {
        $this->insert($userInfo);
    }

    /*更新用户记录*/
    public function updateUserInfo($userInfo) {
        $this->update($userInfo);
    }

    /*删除多条用户信息*/
    public function deleteUserInfos($user_names){
        $user_nameArray = explode(",",$user_names);
        foreach ($user_nameArray as $user_name) {
            $this->user_name = $user_name;
            $this->delete();
        }
        return count($user_nameArray);
    }
    /*根据主键获取用户记录*/
    public function getUserInfo($user_name) {
        $userInfo = UserInfoModel::where("user_name",$user_name)->find();
        return $userInfo;
    }

    /*按照查询条件分页查询用户信息*/
    public function queryUserInfo($user_name, $name, $birthDate, $telephone, $currentPage) {
        $startIndex = ($currentPage-1) * $this->rows;
        $where = null;
        if($user_name != "") $where['user_name'] = array('like','%'.$user_name.'%');
        if($name != "") $where['name'] = array('like','%'.$name.'%');
        if($birthDate != "") $where['birthDate'] = array('like','%'.$birthDate.'%');
        if($telephone != "") $where['telephone'] = array('like','%'.$telephone.'%');
        $userInfoRs = UserInfoModel::where($where)->limit($startIndex,$this->rows)->select();
        /*计算总的页数和总的记录数*/
        $this->recordNumber = UserInfoModel::where($where)->count();
        $mod = $this->recordNumber % $this->rows;
        $this->totalPage = (int)($this->recordNumber / $this->rows);
        if($mod != 0) $this->totalPage++;
        return $userInfoRs;
    }

    /*按照查询条件查询所有用户记录*/
  public function queryOutputUserInfo( $user_name,  $name,  $birthDate,  $telephone) {
        $where = null;
        if($user_name != "") $where['user_name'] = array('like','%'.$user_name.'%');
        if($name != "") $where['name'] = array('like','%'.$name.'%');
        if($birthDate != "") $where['birthDate'] = array('like','%'.$birthDate.'%');
        if($telephone != "") $where['telephone'] = array('like','%'.$telephone.'%');
        $userInfoRs = UserInfoModel::where($where)->select();
        return $userInfoRs;
    }

    /*查询所有用户记录*/
    public function queryAllUserInfo(){
        $userInfoRs = UserInfoModel::where(null)->select();
        return $userInfoRs;

    }

}
