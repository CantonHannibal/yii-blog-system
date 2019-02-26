<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/2
 * Time: 9:28
 */
namespace  frontend\controllers\base;
/*
 * 基础控制器
 * */
use yii\web\Controller;
use frontend\Tools\Tools;
class BaseController extends  Controller
{
    public function  beforeAction($action)
    {
        if(!parent::beforeAction($action)){
            return false;
        }
        Tools::DebugToolbarOff();
        return true;
    }
}