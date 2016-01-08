<?php
/**
 * Created by PhpStorm.
 * User: andreyshade
 * Date: 05.01.16
 * Time: 7:13
 * @var $books \app\models\Books
 */
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\DataColumn;
use yii\helpers\Html;
use app\models\Books;
?>

<?php $this->registerJsFile('/js/magnific-popup.js');?>

<?php
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>

<div class="row">

</div>

<?= GridView::widget ([
    'dataProvider' => $books,
    'showOnEmpty' => true,
    'summary' => false,
    'emptyText' => 'There are no available books',
    'columns' => [
        Books::FIELD_ID,
        [
            'class' => DataColumn::className(),
            'label' => 'Название',
            'attribute' => Books::FIELD_NAME
        ],
        [
            'class' => DataColumn::className(),
            'attribute' => Books::FIELD_PREVIEW,
            'label' => 'Превью',
            'format' => 'raw',
            'value' => function ($model) {
            /* @var $model Books */
                return Html::a(Html::img($model->preview,[
                'data-src' => 'holder.js/120x120',
	            'class' => "img-responsive",
                'style' => 'width: 120px'
                ]), $model->preview, ['class' => 'image-link']);
            }
        ],
        [
            'class' => DataColumn::className(),
            'label' => 'Автор',
            'value' => function($model){
            /* @var $model Books */
                return $model->author->getFullName();
            }
        ],
        [
            'class' => DataColumn::className(),
            'label' => 'Дата выхода книги',
            'value' => function($model) {
                return Yii::$app->formatter->asDate($model->date);
            }
        ],
        [
            'class' => DataColumn::className(),
            'label' => 'Дата добавления',
            'attribute' => Books::FIELD_DATE_CREATE
        ],
        [
            'class' => ActionColumn::className(),
            'header' => 'Кнопки действий',
            'visible' => !Yii::$app->user->isGuest,
            'buttons' => [
                'delete' => function($url, $model) {
                    /* @var Books $model */
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', [
                        'delete-book',
                        Books::FIELD_ID => $model->id,
                    ], [
                        'data-confirm' => Yii::t('yii', 'Вы уверены что хотите удалить эту книгу?'),
                    ]);
                }
            ]
        ]
    ]
]) ?>