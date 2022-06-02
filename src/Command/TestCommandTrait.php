<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Main;
use Symfony\Component\Console\Style\SymfonyStyle;

trait TestCommandTrait
{
    private function enableOtherFilterWithLanguage(string $language): void
    {
        $this->entityManager
            ->getFilters()
            ->enable('other_language_filter')
            ->setParameter('language', $language);
    }

    private function preloadOthers(array $mains): void
    {
        $this->entityManager->createQueryBuilder()
            ->from(Main::class, 'm')
            ->select('PARTIAL m.{id}, o')
            ->leftJoin('m.others', 'o')
            ->where('m.id in (:mains)')
            ->setParameter('mains', $mains)
            ->getQuery()
            ->getResult();
    }

    private function renderOthersInTable(SymfonyStyle $io, array $others): void
    {
        $table = $io->createTable();

        $table->setHeaders(['name' => 'Name', 'language' => 'Language']);

        foreach ($others as $other) {
            $table->addRow(
                [
                    'name' => $other->getName(),
                    'language' => $other->getLanguage(),
                ]
            );
        }

        $table->render();
    }
}
