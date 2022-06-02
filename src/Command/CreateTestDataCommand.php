<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Main;
use App\Entity\Other;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateTestDataCommand extends Command
{
    protected static $defaultName = 'app:create-test-data';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($this->entityManager->getRepository(Main::class)->count([]) !== 0) {
            $io->info('Test data already created');

            return 0;
        }

        $main = new Main();
        $this->entityManager->persist($main);

        $otherEn = new Other('Test 1', 'en');
        $otherCs = new Other('Test 2', 'cs');

        $main->addOther($otherEn);
        $main->addOther($otherCs);

        $this->entityManager->persist($otherEn);
        $this->entityManager->persist($otherCs);

        $this->entityManager->flush();

        $io->success('Test data created');

        return 0;
    }
}
