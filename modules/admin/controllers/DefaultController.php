<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii;
use app\models\MyList;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','admin','index'],
                'rules' => [
                    [
                        'actions' => ['logout','admin','index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string|yii\web\Response
     */
    public function actionCreate()
    {
        $identification = MyList::getData();
        if ($_POST['MyList']) {
            $login = $_POST['MyList']['login'];
            $password = $_POST['MyList']['password'];
            $identification->login = $login;
            $identification->password = $password;
            if ($identification->validate() && $identification->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('create',['identification' => $identification]);
    }



}
