<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 14:32
 */

namespace app\models\base;


use yii\web\Request;

class Dto
{
    public static function createFromRequest(Request $request)
    {
        $props = array_keys(get_class_vars(static::class));
        $dto = new static();

        foreach ($props as $prop) {
            $dto->$prop = $request->getBodyParam($prop);
        }

        return $dto;
    }
}