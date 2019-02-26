<?php
namespace  frontend\widgets\post;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/12
 * Time: 15:01
 */
use yii\data\Pagination;
use yii\helpers\Url;
use common\models\PostsModel;
use frontend\models\PostsForm;
use Yii;
use yii\base\Widget;

class PostsWidget extends Widget{
    public $title='';
    public $limit=6;
    public $more=true;
    public $page=true;//分页

    public function run(){
        $curPage=Yii::$app->request->get('page',1);
        //查询条件
        $cond=['=','is_valid',PostsModel::IS_VALID];
        $res=PostsForm::getList($cond,$curPage,$this->limit);
//        print_r($res);
        $result['title']=$this->title?:"最新文章";
        $result['more']=Url::to(['posts/index']);
        $result['body']=$res['data']?:[];
        $result['create']=Url::to(['posts/create']);
        if($this->page){
            $pages=new Pagination(['totalCount'=>$res['count'],'pageSize'=>$res['pageSize']]);
            $result['page']=$pages;
        }
//        print_r($result['page']);
        return $this->render('index',['data'=>$result]);
    }

}