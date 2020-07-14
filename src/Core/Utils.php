<?php


namespace Ifmo\Web\Core;


class Utils
{
    public static function getRandom(){
        // TODO:: Сгенерировать сложный айди сессии
        $num = rand(0,9999);
        return $num;
    }
}