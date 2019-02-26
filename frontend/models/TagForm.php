<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/5
 * Time: 10:43
 */

namespace frontend\models;
use common\models\Tags;
use yii\base\Model;

class TagForm extends  Model
{
        public $id;
        public $tags;
        public function rules(){
            return[
              ['tags','required'],
                ['tags','each','rule'=>['string']],
            ];
        }
        public function saveTags(){
//            return ;
            $ids=[];
            if(!empty($this->tags)){
                foreach ($this->tags as $tag){
                    $ids[]=$this->_saveTag($tag);
                }
            }
            return $ids;
        }
        public function _saveTag($tag){
            $model=new Tags();
            $res =$model->find()->where(['tag_name'=>$tag])->one();
            if(!$res){
                $model->tag_name=$tag;
                $model->post_num=1;
                if(!$model->save()){
                    throw new \Exception("保存标签失败！");
                }

//                error_log(print_r($model->id,true ));
                return $model->id;//由于Tags的ID是自增ID，使用save()插入后id会自增
            }else{
                $res->updateCounters(['post_num'=>1]);
//                echo 'success';
            }
            return $res->id;//否则采用的是查询得到的ID
        }
}