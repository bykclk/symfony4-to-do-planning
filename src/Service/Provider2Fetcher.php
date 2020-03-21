<?php


namespace App\Service;

use App\Entity\Task;

class Provider2Fetcher implements FetcherInterface
{
    const API_URL = 'http://www.mocky.io/v2/5d47f235330000623fa3ebf7';

    public function getTasks()
    {
        $results = json_decode(file_get_contents(self::API_URL), true);

        return array_map(function (array $result) {
            $name = array_key_first($result);
            $difficulty = $result[$name]['level'];
            $duration = $result[$name]['estimated_duration'];
            $task = new Task();
            $task
                ->setName($name)
                ->setDifficulty($difficulty)
                ->setDuration($duration);;
            return $task;
        }, $results);

    }
}