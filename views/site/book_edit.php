<?php
/**
 * Created by PhpStorm.
 * User: andreyshade
 * Date: 10.01.16
 * Time: 23:41
 */
?>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use app\models\Books;
use app\models\BooksForm;
use app\models\Authors;
?>
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <?php $form = ActiveForm::begin([
    'options' => [
                'enctype' => 'multipart/form-data'
            ]
    ]); ?>
        <?= $form->field($model, BooksForm::FIELD_ID)->textInput(['readonly' => true]);?>

        <?= $form->field($model, BooksForm::FIELD_DATE_CREATE)->textInput(['readonly' => true]);?>

        <?= $form->field($model, BooksForm::FIELD_DATE_UPDATE)->textInput(['readonly' => true]);?>

        <?= $form->field($model, BooksForm::FIELD_NAME);?>

        <?= $form->field($model, BooksForm::FIELD_PREVIEW)->fileInput();?>


        <?= $form->field($model, BooksForm::FIELD_AUTHOR_ID)
            ->dropDownList(ArrayHelper::map(Authors::find()->all(),  Authors::FIELD_ID, Authors::FULLNAME)) ?>

        <?= $form->field($model, BooksForm::FIELD_DATE)->widget(DatePicker::className(),[
            'language' => 'ru',
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy'
            ]])?>

        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-default pull-right']) ?>

    <?php $form->end() ?>
    </div>
</div>
