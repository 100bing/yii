<?php
namespace backend\models;
use yii\base\Model;
use yii\rbac\Permission;

class PermissionFrom extends Model{
    //创建名称
    public $name; //名称
    public $description;//权限描述
    //创建规则
    public function rules(){
        return[
            [['name','description'],'required'],

        ];

    }
    public function attributeLabels(){
        return[
            'name'=>'名称',
            'description'=>'描述',
        ];
    }
    public function addPermission(){
        $authManger=\Yii::$app->authManager;
        //创建权限
        //创建权限先判断全选是否存在
        if($authManger->getPermission($this->name)){
            $this->addError('name','权限已存在');
        }
        else{
            $permission=$authManger->createPermission($this->name);
            $permission->description=$this->description;
            //保存数据表
            return $authManger->add($permission);
        }
        return false;

    }
    //穿件从权限中加载数据的方法
    public function loadData(Permission $permission){
        $this->name = $permission->name;
        $this->description = $permission->description;
    }
    //更新权限
    public function updatePermission($name){
        $authManager=\Yii::$app->authManager;
        $permission=$authManager->getPermission($name);
        //判断修改或的权限名是否已存在
        if($name!=$this->name&& $authManager->getPermission($this->name)){
            $this->addError('name','权限已存在');
        }else{
            $permission->name=$this->name;
            $permission->description=$this->description;
            //跟新
            return $authManager->update($name,$permission);
        }
        return false;



    }



}