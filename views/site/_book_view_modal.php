<?php
/**
 * Created by PhpStorm.
 * User: andreyshade
 * Date: 10.01.16
 * Time: 20:33
 */
use yii\bootstrap\Modal;
use yii\widgets\DetailView;
use app\models\Books;

/**
 * @var Books $model
 */
?>
<?php
Modal::begin([
    'id' => 'book-view-modal',
    'header' => '<h2>Информация о книге</h2>',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>'
]);

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label' => 'ID',
            'value' => $model->id
        ],
        [
            'label' => 'Название',
            'value' => $model->name

        ],
        [
            'label' => 'Превью',
            'format' => ['image',['width'=>'120']],
            'value' => $model->preview
        ],
        [
            'label' => 'Автор',
            'value' => $model->author->getFullName()
        ],
        [
            'label' => 'Дата выхода книги',
            'value' => $model->date
        ],
        [
            'label' => 'Дата добавления книги',
            'value' => $model->date_create
        ],
        [
            'label' => 'Дата последнего изменения',
            'value' => $model->date_update
        ],
    ],
]);

Modal::end();
?>