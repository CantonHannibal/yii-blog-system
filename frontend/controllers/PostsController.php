<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/2
 * Time: 9:28
 */

namespace frontend\controllers;
use common\models\PostExtends;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use common\models\CatsModel;
use frontend\models\PostsForm;


use frontend\controllers\base\BaseController;

class PostsController extends BaseController
{

    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'index', 'view'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create','upload','ueditor'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                    //    'roles' => ['?'],//?代表不登陆才可以访问
                    ],
                    [
                        'actions' => ['create','upload','ueditor','index'],
                        'allow' => true,
                        'roles' => ['@'],//@代表登录后才可访问
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    '*'=>['get','post'],//所有方法都可以用get和post
//                    'create' => ['get','post'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
//        $model=new PostsForm();
//        $data=$model->getList();
//            return $this->render('index',['data'=>$data]);
    }

    public function actionCreate(){//文章控制
        $model = new PostsForm();//创建显示的model(这个不是ActiveRecord类型的model)----model
        //获取所有分类
        $model->setScenario(PostsForm::SCENARIO_CREATE);

        if($model->load(Yii::$app->request->post())&&$model->validate()){
            if(!$model->create()){
                Yii::$app->session->setFlash('warning',$model->_lastError);
            }else{
                return $this->redirect(['posts/view','id'=>$model->id]);
            }
        }
//测试dropdowmlist
        $cat = CatsModel::getAllCats();//使用Model的方法，不要直接对数据库进行操作---controller
        return $this->render('create', ['model' => $model, 'cat' => $cat]);//渲染到posts目录下的create.php----views
    }
    public function actions(){//富文本编辑以及缩略图上传
        return [
            'upload'=>[
                'class'=>'common\widgets\file_upload\UploadAction',
                'config'=>[
                    'imagePathFormat'=>"/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ]
        ];
    }
    public function actionView($id){
        $model =new PostsForm();
        $data=$model->getViewById($id);


        $model=new PostExtends();
        $model->upCounter(['post_id'=>$id],'browser',1);
//        print_r($data['browser']);
        return $this->render('view',['data'=>$data]);
    }
}