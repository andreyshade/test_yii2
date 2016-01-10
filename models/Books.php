<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property integer $id
 * @property string $name
 * @property string $date_create
 * @property string $date_update
 * @property string $preview
 * @property string $date
 * @property integer $author_id
 *
 * @property Authors $author
 */
class Books extends \yii\db\ActiveRecord {

    const FIELD_ID  = 'id';
    const FIELD_NAME = 'name';
    const FIELD_DATE_CREATE = 'date_create';
    const FIELD_DATE_UPDATE = 'date_update';
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
            [[self::FIELD_DATE_CREATE, self::FIELD_DATE_UPDATE, self::FIELD_DATE], 'safe'],
            [[self::FIELD_AUTHOR_ID], 'integer'],
            [[self::FIELD_NAME, self::FIELD_PREVIEW], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            self::FIELD_ID => 'ID',
            self::FIELD_NAME => 'Name',
            self::FIELD_DATE_CREATE => 'Data Create',
            self::FIELD_DATE_UPDATE => 'Date Update',
            self::FIELD_PREVIEW => 'Preview',
            self::FIELD_DATE => 'Date',
            self::FIELD_AUTHOR_ID => 'Author ID',
        ];
    }

    const RELATION_AUTHOR = 'author';
    public function getAuthor(){
        return $this->hasOne(Authors::className(), [Authors::FIELD_ID => self::FIELD_AUTHOR_ID]);
    }
}
