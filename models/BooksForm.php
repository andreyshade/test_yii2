<?php
/**
 * Created by PhpStorm.
 * User: andreyshade
 * Date: 10.01.16
 * Time: 23:46
 */

namespace app\models;

use Yii;
use DateTime;
use yii\db\Expression;
use yii\base\Model;
use app\models\Books;

class BooksForm extends Model {
    public $id;
    public $name;
    public $date;
    public $author_id;
    public $date_create;
    public $date_update;
    public $preview;

    const FIELD_ID = 'id';
    const FIELD_AUTHOR_ID = 'author_id';
    const FIELD_NAME = 'name';
    const FIELD_DATE = 'date';
    const FIELD_DATE_CREATE = 'date_create';
    const FIELD_DATE_UPDATE = 'date_update';
    const FIELD_PREVIEW = 'preview';


    public function rules() {
        return [
            [[self::FIELD_AUTHOR_ID, self::FIELD_NAME, self::FIELD_NAME, self::FIELD_DATE], 'required']
        ];
    }

    public function attributeLabels() {
        return [
            self::FIELD_AUTHOR_ID => 'Автор',
            self::FIELD_ID => 'ID',
            self::FIELD_DATE => 'Дата выхода книги',
            self::FIELD_DATE_CREATE => 'Дата создания записи',
            self::FIELD_DATE_UPDATE => 'Дата последнего обновления',
            self::FIELD_PREVIEW => 'Превью',
            self::FIELD_NAME => 'Название книги'
        ];
    }

    public function initFormModel($model) {
        /* @var Books $model */
        $this->id = $model->id;
        $this->name = $model->name;
        $this->date = DateTime::createFromFormat('Y-m-d', $model->date)->format( 'd/m/Y' );
        $this->author_id = $model->author_id;
        $this->date_create = $model->date_create;
        $this->date_update = $model->date_update;
        $this->preview = $model->preview;
    }
    public function save() {
        if (!$this->validate()) {
			return false;
		}
        $model = Books::findOne($this->id);
        $model->name = $this->name;
        // TODO image update
        $model->author_id = $this->author_id;
        $model->date = DateTime::createFromFormat('d/m/Y', $this->date)->format( 'Y-m-d' );;
        $model->date_update = new Expression('NOW()');
        $model->save();
        return true;
    }
}