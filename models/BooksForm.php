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
use Imagine\Gd;
use Imagine\Image\Box;
use yii\web\UploadedFile;
use yii\db\Expression;
use yii\base\Model;

class BooksForm extends Model {
    public $id;
    public $name;
    public $date;
    public $author_id;
    public $date_create;
    public $date_update;
    public $preview;
    public $imageSizeLimit = ['width' => 120, 'height' => 120];

    const FIELD_ID = 'id';
    const FIELD_AUTHOR_ID = 'author_id';
    const FIELD_NAME = 'name';
    const FIELD_DATE = 'date';
    const FIELD_DATE_CREATE = 'date_create';
    const FIELD_DATE_UPDATE = 'date_update';
    const FIELD_PREVIEW = 'preview';


    public function rules() {
        return [
            [[self::FIELD_AUTHOR_ID, self::FIELD_NAME, self::FIELD_NAME, self::FIELD_DATE], 'required'],
            [[self::FIELD_PREVIEW], 'file', 'skipOnEmpty' => true,'extensions' => 'png, jpg', 'maxSize' => ini_get('upload_max_filesize')*1024*1024],
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
        $model = Books::findOne($this->id);
        $fileInstance = UploadedFile::getInstance($this, self::FIELD_PREVIEW);
        if ($fileInstance) {
			$filePath = 'images/' . $fileInstance->baseName . '.' . $fileInstance->extension;
			$model->preview = $fileInstance->baseName . '.' . $fileInstance->extension;
			$fileInstance->saveAs($filePath,false);
            $imagine = new Gd\Imagine();
			try {
                $filePath = 'images/preview_' . $fileInstance->baseName . '.' . $fileInstance->extension;
				$img = $imagine->open($fileInstance->tempName);
				$size = $img->getSize();
				if ($size->getHeight() > $this->imageSizeLimit['width'] || $size->getWidth() > $this->imageSizeLimit['height']) {
					$img->resize(new Box($this->imageSizeLimit['width'], $this->imageSizeLimit['height']));
				}
				$img->save($filePath);//
			} catch (\Imagine\Exception\RuntimeException $ex) {
				$this->addError(self::FIELD_PREVIEW, 'Imagine runtime exception: ' . $ex->getMessage());
				return FALSE;
			}
        }
        if (!$this->validate()) {
			return false;
		}
        $model->name = $this->name;
        $model->author_id = $this->author_id;
        $model->date = DateTime::createFromFormat('d/m/Y', $this->date)->format( 'Y-m-d' );;
        $model->date_update = new Expression('NOW()');
        $model->save();
        return true;
    }
}