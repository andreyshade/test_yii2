<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "authors".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 */
class Authors extends \yii\db\ActiveRecord
{
    const FIELD_ID = 'id';
    const FIELD_FIRSTNAME = 'firstname';
    const FIELD_LASTNAME = 'lastname';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[self::FIELD_FIRSTNAME, self::FIELD_LASTNAME], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            self::FIELD_ID => 'ID',
            self::FIELD_FIRSTNAME => 'Firstname',
            self::FIELD_LASTNAME => 'Lastname',
        ];
    }

    public function getFullName () {
        return $this->firstname . ' ' . $this->lastname;
    }
}
