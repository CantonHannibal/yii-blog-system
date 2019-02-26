<?php

namespace frontend\controllers;

use frontend\controllers\base\BaseController;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\User;

class UserController extends BaseController
{
    public function actionIndex()
    {
        $query = User::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $users = $query->orderBy('username')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'users' => $users,
            'pagination' => $pagination,
        ]);
    }
}