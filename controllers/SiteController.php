<?php

namespace app\controllers;

use app\models\Captcha;
use app\models\Form;
use app\models\LoginForm;
use app\models\MyList;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        Yii::setAlias('@cookies',Yii::getAlias('@webroot'). '/assets/tmp');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $search = new Form();
        $captcha = new Captcha();
        $identification = MyList::getData();
        $login = $identification -> login;
        $password = $identification -> password;
        $code = NULL;
        if ($captcha->load(Yii::$app->request->post())) {
            $code = ($_POST['Captcha']['captcha']);
        }
        $status = MyList::initializanion($login, $password, $code, $captcha);
        if ($search->load(Yii::$app->request->post())) {
            $inquiry = ($_POST['Form']['path']);
            $session = Yii::$app->session;
            $session['inquiry'] = $inquiry;
            $session['id'] = 0;
            $page = 0;
            $torr = MyList::get_content($inquiry,$page);
            return $this->render('pagination', ['torr' => $torr, 'search' => $search, 'inquiry' => $inquiry]);
        }
        $torr = 1;
        return $this->render('index', ['torr' => $torr, 'search' => $search, 'captcha' => $captcha, 'status' => $status]);
    }

    /**
     * @return string
     */
    public function actionPagination()
    {
        $session = Yii::$app->session;
        $inquiry = $session['inquiry'];
        $session['id'] = $session['id']+1;
        $page = $session['id'];
        $torr = MyList::get_content($inquiry,$page);
        return $this->render('pagination', ['torr' => $torr, 'id' => $page, 'inquiry' => $inquiry]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionDownload($id)
    {
        $session = Yii::$app->session;
        $link = $session["download[$id]"];
        MyList::download($link);
        $inquiry = $session['inquiry'];
        $page = $session['id'];
        $torr = MyList::get_content($inquiry,$page);
        return $this->render('pagination', ['torr' => $torr, 'id' => $page, 'inquiry' => $inquiry]);
    }

}
