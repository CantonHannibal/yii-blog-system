<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/2
 * Time: 9:52
 */

namespace frontend\models;

use common\models\PostsModel;
use common\models\RelationPostTags;
use yii\base\Model;
use Yii;
use yii\db\Query;
use yii\web\NotFoundHttpException;

/*
 * 文章表单
 * */

class PostsForm extends Model
{
    public $id;
    public $title;
    public $content;
    public $label_img;
    public $cat_id;
    public $tags;
    public $_lastError = "";
//1.常量作为场景的标识
    const SCENARIO_CREATE = 'create';//创建
    const SCENARIO_UPDATE = 'update';//更新
//2.常量 EventAfterCreate场景：
    const EVENT_AFTER_CREATE='eventAfterCreate';
    const EVENT_AFTER_UPDATE='eventAfterUpdate';
//场景设置
    public function scenarios()
    {
        $scenarios = [//更新时间和创建时间不同，所以不可同时出现在下方
            self::SCENARIO_CREATE => ['title', 'content', 'label_img', 'cat_id', 'tags'],
            self::SCENARIO_UPDATE => ['title', 'content', 'label_img', 'cat_id', 'tags'],
        ];
        return array_merge(parent::scenarios(), $scenarios); // TODO: Change the autogenerated stub
    }

    public function rules()
    {
        return [
            [['id', 'title', 'content', 'cat_id'], 'required'],
            [['id', 'cat_id'], 'integer'],
            ['title', 'string', 'min' => 4, 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => '编码',
            'title' => '标题',
            'content' => '内容',
            'label_img' => '标签图',
            'tags' => '标签',
            'cat_id' => '分类',
        ];
    }
//文章之创建
    public function create()
    {
        //事务
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new PostsModel();
            $model->setAttributes($this->attributes);
            $model->summary = $this->_getSummary();
            $model->user_id = Yii::$app->user->identity->id;
            $model->user_name = Yii::$app->user->identity->username;
            $model->is_valid=PostsModel::IS_VALID;
            $model->created_at=time();
            $model->updated_at=time();
            if(!$model->save())
                throw new \Exception('文章保存失败！');
            $this->id=$model->id;

            //调用事件
            $data=array_merge($this->getAttributes(),$model->getAttributes());//attributes()和getAttributes不同，前者返回属性名字后者返回属性值
            $this->_eventAfterCreate($data);

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->_lastError = $e->getMessage();
            return false;
        }
    }

    private function _getSummary($s=0,$e=90,$char='utf-8'){
        if(empty($this->content)){
            return null;

        }
        return (mb_substr(str_replace('&nbsp','',strip_tags($this->content)),$s,$e,$char));
    }
    //创建后的事件
    public function _eventAfterCreate($data){

        //添加事件
//        echo $data['tags'];
        $this->on(self::EVENT_AFTER_CREATE,[$this,'_eventAddTag'],$data);
        //触发事件
        $this->trigger(self::EVENT_AFTER_CREATE);
    }
    public function _eventAddTag($event){
        //保存标签
        $tag=new TagForm();
//        echo $event->data['tags'];
        $tag->tags=$event->data['tags'];
        $tagids=$tag->saveTags();
//        删除原先的关联关系
        RelationPostTags::deleteAll(['post_id'=>$event->data['id']]);
//        批量保存文章和标签的关联关系
        if(!empty($tagids)){
            foreach ($tagids as $k=>$id){
                $row[$k]['post_id']=$this->id;//这里row[k]代表了向数据库插入的一行数据
                $row[$k]['tag_id']=$id;
            }
            //批量插入row
            $res=(new Query())->createCommand()
                ->batchInsert(RelationPostTags::tableName(),['post_id','tag_id'],$row)
                ->execute();
            if(!$res)
                throw new \Exception("关联关系保存失败！");
        }
    }

    public function getViewById($id){
        $res=PostsModel::find()->with('relate.tag','extend')->where(['id'=>$id])->asArray()->one();//一番查询，
        //注意要在对应表上写好getRelate 和 getTag函数
        if(!$res){
            throw new NotFoundHttpException('文章不存在');
        }
        //将通过relate.tag查询出的数据处理成json格式保存在res['tag']：
        $res['tags']=[];//我们需要标签数据用于前端显示
        if(isset($res['relate'])&&!empty($res['relate'])){//非空且有值
            foreach ($res['relate'] as $list){
                $res['tags'][]=$list['tag']['tag_name'];//赋值
            }
        }
//        print_r($res);
        unset($res['relate']);//删除多余数据

        return $res;
    }

    public static function getList($cond,$curPage=1,$pageSize=5,$orderBy=['id'=>SORT_DESC]){//其实列表是另一种形式的内容展示
        $model=new PostsModel();
        $select=['id','title','summary','label_img','cat_id','user_id','user_name',
            'is_valid','created_at','updated_at'
        ];
        $query=$model->find()
            ->select($select)//查询以上数据
            ->where($cond)
            ->with('relate.tag','extend')
            ->orderBy($orderBy);
        //获取分页数据
        $res=$model->getPages($query,$curPage,$pageSize);
        //格式化数据
        $res['data']=self::_formatList($res['data']);
        return $res;
    }

    public static function _formatList($data){//格式化数据,这里的逻辑:通过getList传来的数据我们进行格式化
        //主要我们这里还差一个标签
        foreach ($data as &$list){

            //获取标签名数据
            $list['tags']=[];
            if(isset($list['relate'])&&!empty($list['relate'])){
                foreach ($list['relate']as $lt){
                    $list['tags'][]=$lt['tag']['tag_name'];

                }
                unset($list['relate']);
            }

        }

        return $data;
    }
}