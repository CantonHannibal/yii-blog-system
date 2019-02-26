<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/2
 * Time: 9:47
 */
namespace common\models\base;


use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord{

    //获取分页数据
    public function getPages($query,$curPage=1,$pageSize=10,$search=null){
        if($search) {
            $query = $query->andFilterWhere($search);
        }
            $data['count']=$query->count();
            if(!$data['count']){
                return ['count'=>0,'curPage'=>$curPage,'pageSize'=>$pageSize,'start'=>0,
                'end'=>0,'data'=>[]
                ];
            }
            //超过实际页数，不取curPage为当前页
            //以data['count]=9，pageSize=10,curPage=2为例子：
            //ceil(9/10)=1 ,curPage为1
            //以data['count]=11，pageSize=10,curPage=1为例子：
            //ceil(11/10)=2 ,curPage不变
            $curPage=(ceil($data['count']/$pageSize)<$curPage)
                ?ceil($data['count']/$pageSize):$curPage;
            //当前页
            $data['curPage']=$curPage;
            //每页条数
            $data['pageSize']=$pageSize;
            //起始项
            $data['start']=($curPage-1)*$pageSize+1;
            //末项
            $data['end']=(ceil($data['count']/$pageSize)==$curPage)
                ?$data['count']:($curPage*$pageSize);
            //数据,offset就是告诉数据库从哪里开始查起,limit指定查多少个
            $data['data']=$query
                ->offset(($curPage-1)*$pageSize)
                ->limit($pageSize)
                ->asArray()
                ->all();


            return $data;
    }



}