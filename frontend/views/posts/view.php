<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/6
 * Time: 12:07
 */
$this->title=$data['title'];
$this->params['breadcrumbs'][]=['label'=>'文章','url'=>['posts/index']];
$this->params['breadcrumbs'][]=$this->title;
?>
<div class="row">
    <div class="col-lg-9">
        <div class="page-title">
            <h1><?=$data['title'] ?></h1>
        </div>
        <span>作者：<?=$data['user_name']?></span>
        <span>发布：<?=date('Y-m-d',$data['created_at'])?></span>
        <span>浏览：<?=isset($data['extend']['browser'])?$data['extend']['browser']:0?></span>
    </div>
    <?=$data['content']?>
    <div class="page-tag">
        标签：
        <?php foreach ($data['tags']as $tag):?>
        <span><a href="#"><?=$tag?></a></span>
        <?php endforeach;?>
    </div>
    <div class="col-lg-3">

    </div>
</div>
