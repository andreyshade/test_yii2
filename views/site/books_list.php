<?php
/**
 * Created by PhpStorm.
 * User: andreyshade
 * Date: 05.01.16
 * Time: 7:13
 * @var $books Books
 * @var $searchModel BooksSearch
 */
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use app\models\Books;
use app\models\BooksSearch;
use app\models\Authors;
?>

<?php $this->registerJsFile('/js/magnific-popup.js');?>

<?php
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>


    <?php $form = ActiveForm::begin([
        'options' => [
                    'class' => 'form-inline',
                    'enctype' => 'multipart/form-data'
                ],
        'fieldConfig' => ['template' => '{input}']
        ]); ?>
        <?= $form->errorSummary($searchModel); ?>
        <?= $form->field($searchModel, BooksSearch::FIELD_AUTHOR_ID)
        ->dropDownList(ArrayHelper::map(Authors::find()->all(),  Authors::FIELD_ID, Authors::FULLNAME),
            ['prompt'=>'автор']) ?>
        &nbsp;
        <?= $form->field($searchModel, BooksSearch::FIELD_NAME)->textInput(['placeholder' => 'название книги'])?>
        <br>
        <br>
        Дата выхода книги:&nbsp;
        <?= $form->field($searchModel, BooksSearch::START_DATE)->widget(DatePicker::className(),[
            'options' => ['placeholder' => 'дата начала'],
            'language' => 'ru',
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy'
            ]])?>
        &nbsp;до&nbsp;
            <?= $form->field($searchModel, BooksSearch::END_DATE)->widget(DatePicker::className(),[
            'options' => ['placeholder' => 'дата окончания'],
            'language' => 'ru',
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy'
            ]])?>
        <?= Html::submitButton('Искать', ['class' => 'btn btn-default pull-right']) ?>
    <?php ActiveForm::end(); ?>

<br>

<?= GridView::widget ([
    'dataProvider' => $books,
    'showOnEmpty' => true,
    'summary' => false,
    'emptyText' => 'К сожелению, не найдено книг по данному запросу, попробуйте изменить условия поиска',
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
                /* @var Books $model */
                return Yii::$app->formatter->asDate($model->date);
            }
        ],
        [
            'class' => DataColumn::className(),
            'label' => 'Дата добавления',
            'value' => function($model) {
                /* @var Books $model */
                return Yii::$app->formatter->asDate($model->date_create);
            }
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