<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginFormAdmin;
use backend\models\Videos;
use backend\models\Local;
use backend\models\Preview;
use backend\models\Direct;
use backend\models\Ip;
use yii\data\Pagination;

/**
 * Site controller
 */
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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = Videos::find()->where(['availability' => Videos::STATUS_OFF])->orderBy('id DESC')->all();
        $countVideos = Videos::find()->count();
        $countUsers = \frontend\models\User::find()->count();
        $local = Local::find()->where(['check_id' => Local::STATUS_PENDING])->orderBy('id DESC')->all();
        $preview = Preview::find()->where(['check_id' => Preview::STATUS_PENDING])->orderBy('id DESC')->all();
        $direct = Direct::find()->where(['check_id' => Direct::STATUS_PENDING])->orderBy('id DESC')->all();
        $vidcommentsAll = \frontend\models\VidComments::find();
        $vidcommentsCountQuery = clone $vidcommentsAll;
        $vidcommentsPages = new Pagination(['totalCount' => $vidcommentsCountQuery->count(), 'pageSize' => 10]);
        $vidcommentsPages->pageSizeParam = false;
        $vidcomments = $vidcommentsAll->offset($vidcommentsPages->offset)->orderBy('id DESC')
            ->limit($vidcommentsPages->limit)
            ->all();
        $commentCount = $vidcommentsCountQuery->count();
        $comments = \frontend\models\Comments::find()->orderBy('id DESC')->limit(20)->all();
        $ipUser = new Ip();

        return $this->render('index', [
            'model' => $model,
            'countVideos' => $countVideos,
            'countUsers' => $countUsers,
            'commentCount' => $commentCount,
            'local' => $local,
            'preview' => $preview,
            'direct' => $direct,
            'vidcomments' => $vidcomments,
            'ipUser' => $ipUser,
            'vidcommentsPages' => $vidcommentsPages,

        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginFormAdmin();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
