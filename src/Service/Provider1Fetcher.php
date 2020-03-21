<?php


namespace App\Service;

use App\Entity\Task;

class Provider1Fetcher implements FetcherInterface
{
    const API_URL = 'http://www.mocky.io/v2/5d47f24c330000623fa3ebfa';

    public function getTasks()
    {
        $results = json_decode(file_get_contents(self::API_URL), true);

        return array_map(function (array $result) {
            $name = $result['id'];
            $difficulty = $result['zorluk'];
            $duration = $result['sure'];
            $task = new Task();
            $task
                ->setName($name)
                ->setDifficulty($difficulty)
                ->setDuration($duration);;
            return $task;
        }, $results);

    }
}