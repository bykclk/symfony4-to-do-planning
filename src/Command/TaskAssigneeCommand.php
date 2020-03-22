<?php

namespace App\Command;

use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Service\AssigneeService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TaskAssigneeCommand extends Command
{
    protected static $defaultName = 'app:task:assignee';

    /** @var AssigneeService */
    private $assigneeService;

    /** @var TaskRepository */
    private $taskRepository;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(AssigneeService $assigneeService, TaskRepository $taskRepository, UserRepository $userRepository)
    {
        $this->assigneeService = $assigneeService;
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('assign task to users');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $tasks = $this->taskRepository->findBy([]);
        $users = $this->userRepository->findAll();

        $this->assigneeService
            ->setTasks($tasks)
            ->setUsers($users)
            ->assignee();

        $io->success('Assignee successfully!');

        return 0;
    }
}
