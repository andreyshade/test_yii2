<?php
/**
 * Created by PhpStorm.
 * User: andreyshade
 * Date: 05.01.16
 * Time: 16:56
 */

namespace app\models;


class BooksSearch extends Books {

    public function search() {
        $query = self::find();
        return $query;
    }
}