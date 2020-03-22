<?php

namespace App\Twig;

use App\Entity\Task;
use App\Entity\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('durationTheWork', [$this, 'durationTheWork']),
        ];
    }

    public function durationTheWork(array $users)
    {
        $arr = array_map(function (User $user) {
            return array_sum(array_map(function (Task $task) {
                    return $task->getDifficulty() * $task->getDuration();
                }, $user->getTasks()->toArray())) / (User::WEEKLY_WORKING_TIME * $user->getDifficulty());
        }, $users);
        rsort($arr);
        return number_format($arr[0], 1);
    }
}
