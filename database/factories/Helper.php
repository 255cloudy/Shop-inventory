<?php
namespace Database\Factories;
/*
*
*/
class Helper {
    public static function getRandom($array){
        $index = array_rand($array, 1);
        return $array[$index];
    }
}
