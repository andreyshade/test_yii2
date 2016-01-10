<?php

namespace app\controllers;

use app\models\Authors;
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
		if ($searchModel->load(Yii::$app->request->post())) {
            $searchModel->validate();
        };

        $books = new ActiveDataProvider([
			'query' => $searchModel->search(),
            'sort' =>[
                'attributes' => [
                    BooksSearch::FIELD_ID => [
                        'asc' => [Books::FIELD_ID => SORT_ASC],
                        'desc' => [Books::FIELD_ID => SORT_DESC],
                        'default' => ''
                    ],
                    BooksSearch::FIELD_NAME => [
                        'asc' => [Books::FIELD_NAME => SORT_ASC],
                        'desc' => [Books::FIELD_NAME => SORT_DESC],
                        'default' => ''
                    ],
                    BooksSearch::FIELD_FULL_AUTHOR_NAME => [
						'asc' => [Authors::FIELD_FIRSTNAME => SORT_ASC, Authors::FIELD_LASTNAME => SORT_ASC],
						'desc' => [Authors::FIELD_FIRSTNAME => SORT_DESC, Authors::FIELD_LASTNAME => SORT_DESC],
						'default' => ''
					],
                    BooksSearch::FIELD_DATE => [
                        'asc' => [Books::FIELD_DATE => SORT_ASC],
                        'desc' => [Books::FIELD_DATE => SORT_DESC],
                        'default' => ''
                    ],
                    BooksSearch::FIELD_DATE_CREATE => [
                        'asc' => [Books::FIELD_DATE_CREATE => SORT_ASC],
                        'desc' => [Books::FIELD_DATE_CREATE => SORT_DESC],
                        'default' => ''
                    ]

                ]
            ]
		]);

        return $this->render('books_list', [
           'books' => $books,
           'searchModel' => $searchModel
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
