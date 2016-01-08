<?php

namespace app\controllers;

use app\models\Books;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\ActiveDataProvider;
use app\models\BooksSearch;

class SiteController extends Controller {
    public function behaviors() {
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

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect('books-list');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('books-list');
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout() {
        return $this->render('about');
    }

    public function actionBooksList() {
        $searchModel = new BooksSearch();
		$searchModel->load(Yii::$app->request->get());

        $books = new ActiveDataProvider([
			'query' => $searchModel->search()
		]);

        return $this->render('books_list', [
           'books' => $books
        ]);
    }
    public function actionDeleteBook() {
        if (Yii::$app->user->isGuest) {
            throw new \yii\web\HttpException(404);
        };
        if ($id = Yii::$app->request->get(Books::FIELD_ID)) {
			Books::deleteAll([Books::FIELD_ID => $id]);
		}
        Yii::$app->session->setFlash('success', 'Книга успешно удалена.');
		return $this->redirect('books-list');
    }
}
