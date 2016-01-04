<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property integer $id
 * @property string $name
 * @property string $data_create
 * @property string $date_update
 * @property string $preview
 * @property string $date
 * @property integer $author_id
 */
class Books extends \yii\db\ActiveRecord {

    const FIELD_ID  = 'id';
    const FIELD_NAME = 'field_name';
    const FIELD_DATA_CREATE = 'data_create';
    const FIELD_DATA_UPDATE = 'data_update';
    const FIELD_PREVIEW = 'preview';
    const FIELD_DATE = 'date';
    const FIELD_AUTHOR_ID = 'author_id';

    public static function tableName() {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data_create', 'date_update', 'date'], 'safe'],
            [['author_id'], 'required'],
            [['author_id'], 'integer'],
            [['name', 'preview'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'data_create' => 'Data Create',
            'date_update' => 'Date Update',
            'preview' => 'Preview',
            'date' => 'Date',
            'author_id' => 'Author ID',
        ];
    }
}
