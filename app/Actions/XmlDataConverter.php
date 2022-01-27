<?php

namespace App\Actions;

class XmlDataConverter
{
    public static function stringToObject($string){
        return (object) json_decode(json_encode(simplexml_load_string($string)),true);
    }
}
