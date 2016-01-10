<?php
/**
 * Created by PhpStorm.
 * User: andreyshade
 * Date: 05.01.16
 * Time: 16:56
 */

namespace app\models;

use DateTime;
use yii\base\Model;


class BooksSearch extends Books {
    public $startDate;
    public $endDate;


    const START_DATE = 'startDate';
    const END_DATE = 'endDate';


    public function rules() {
         return array_merge(parent::rules(), [
             [[self::START_DATE], 'safe' ],
             [[self::END_DATE], 'validateEndDate']
         ]);
    }

    public function validateEndDate($attribute, $params) {
        if (($this->startDate) && (self::convertDate($this->startDate) > self::convertDate($this->endDate))) {
                $this->addError($attribute, 'Дата начала должна быть меньше даты окончания');
        }
    }

    private static function convertDate ($date) {
        return DateTime::createFromFormat('d/m/Y', $date)->format( 'Y-m-d' );
    }

    public function search() {
        $query = self::find();

        if ($this->author_id) {
            $query->andFilterWhere(['=', Books::FIELD_AUTHOR_ID, $this->author_id]);
        }
        if ($this->name) {
            $query->andFilterWhere(['like', Books::FIELD_NAME , $this->name]);
        }

        if ($this->startDate) {
            $query->andFilterWhere(['>=', Books::FIELD_DATE, self::convertDate($this->startDate)]);
        }

        if ($this->endDate) {
            $query->andFilterWhere(['<=', Books::FIELD_DATE , self::convertDate($this->endDate)]);
        }
        return $query;
    }
}