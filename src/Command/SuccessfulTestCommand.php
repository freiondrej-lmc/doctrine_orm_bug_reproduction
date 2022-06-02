<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Main;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SuccessfulTestCommand extends Command
{
    use TestCommandTrait;

    protected static $defaultName = 'app:test:successful';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->enableOtherFilterWithLanguage('en');

        $main = $this->entityManager->getRepository(Main::class)->findAll()[0];

        $this->preloadOthers([$main]);

        $this->renderOthersInTable($io, $main->getOthers());

        return 0;
    }
}
