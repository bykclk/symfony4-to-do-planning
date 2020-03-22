<?php


namespace App\Service;


use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Hungarian\Hungarian;

class AssigneeService
{

    private $tasks;

    private $users;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function setTasks(array $tasks): self
    {
        $this->tasks = $tasks;

        return $this;
    }

    public function setUsers(array $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function assignee(): void
    {
        $matrix = $this->createMatrix($this->tasks, $this->users);

        $allocation = (new Hungarian($matrix))->solveMin();

        foreach ($allocation as $key => $value) {
            /** @var Task $task */
            $task = $this->tasks[$value];

            /** @var User $user */
            $user = $this->users[$key % count($this->users)];

            $task->setAssignee($user);
        }

        $this->entityManager->flush();
    }

    public function createMatrix(array $tasks, array $users): array
    {
        $matrix = [];
        /** @var Task $task */
        foreach ($tasks as $task) {
            for ($i = 0; $i < count($tasks); $i++) {
                $user = $users[$i % count($users)];
                $matrix[$i][] = (int)round(($task->getDuration() * $task->getDifficulty()) / $user->getDifficulty());
            }
        }

        return $matrix;
    }

}