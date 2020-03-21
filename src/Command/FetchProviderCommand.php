<?php

namespace App\Command;

use App\Entity\Task;
use App\Service\FetchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FetchProviderCommand extends Command
{
    protected static $defaultName = 'app:fetch:provider';

    /** @var FetchService */
    private $fetchService;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(FetchService $fetchService, EntityManagerInterface $entityManager)
    {
        $this->fetchService = $fetchService;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('import providers')
            ->addArgument('providers', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'Provider names');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $providers = $input->getArgument('providers');
        try {
            $tasks = [];
            foreach ($providers as $provider) {
                $tasks = $this->fetchService->setProvider($provider)->fetch();
                /** @var Task $task */
                foreach ($tasks as $task) {
                    $taskEntity = new Task();
                    $taskEntity->setName($task->getName());
                    $taskEntity->setDuration($task->getDuration());
                    $taskEntity->setDifficulty($task->getDifficulty());
                    $taskEntity->setSource($provider);
                    $this->entityManager->persist($taskEntity);
                }
                $this->entityManager->flush();
            }


        } catch (\Exception $e) {
            $io->error($e->getMessage());
        }

        $io->success('Tasks have been imported successfully!');

        return 0;
    }
}
