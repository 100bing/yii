<?php
namespace backend\models;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\rbac\Role;

class RoleFrom extends Model{
    //创建需要的字段
    public $name;
    public $description;
    public $permission=[];
    //创建规则
    public  function rules(){
        return[
            [['name','description'],'required'],
            ['permission','safe'],//safe表示该字段不需要验证

        ];
     }
    //创建标题的中文

    public function attributeLabels(){
        return[
            'name'=>'名称',
            'description'=>'描述',
            'permission'=>'权限'
        ];
    }

    //获取所有权限的选想
    public static function getPermissOption(){
        $authManager=\Yii::$app->authManager;
        return ArrayHelper::map($authManager->getPermissions(),'name','description');//获取所有权限
    }
    public function addRole(){
        $authManager=\Yii::$app->authManager;
        //判断角色是否存在
        if($authManager->getRole($this->name)){
            $this->addError('name','角色名已经存在');
        }else{
            $role=$authManager->createRole($this->name);
            $role->description=$this->description;
            if($authManager->add($role)){//如果保存数据成功
                //关联该角色的权限
                foreach($this->permission as $permissionName){
                    $permission = $authManager->getPermission($permissionName);
                    if($permission) {$authManager->addChild($role,$permission);}
                    }
                return true;

            }
        }
        return false;
    }
    public  function loadData(Role $role){
        $this->name=$role->name;
        $this->description=$role->description;
        $permissions=\Yii::$app->authManager->getPermissionsByRole($role->name);
        foreach($permissions as $permission){

            $this->permission[]=$permission->name;

        }
    }
    public function updateRole($name)
    {
        $authManager = \Yii::$app->authManager;
        $role = $authManager->getRole($name);
        //给角色赋值
        $role->name = $this->name;
        $role->description = $this->description;
        //如果角色名被修改，检查修改后的名称是否已存在
        if($name != $this->name && $authManager->getRole($this->name)){
            $this->addError('name','角色名称已存在');

        }else{
            if($authManager->update($name,$role)){
                //去掉所有与该角色关联的权限
                $authManager->removeChildren($role);
                //关联该角色的权限
                foreach ($this->permission as $permissionName){
                    $permission = $authManager->getPermission($permissionName);
                    if($permission) $authManager->addChild($role,$permission);
                }
                return true;
            }
        }
        return false;
    }

}
