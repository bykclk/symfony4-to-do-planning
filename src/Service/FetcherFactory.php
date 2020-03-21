<?php


namespace App\Service;


class FetcherFactory
{
    public static function create($provider)
    {
        $className = ('\\App\\Service\\'.ucfirst($provider).'Fetcher');
        if(!class_exists($className)){
            throw new \Exception("$className not exist");
        }
        return new $className;
    }
}