<?php

declare(strict_types=1);

namespace App\Filter;

use App\Entity\Other;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class OtherLanguageFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        if ($targetEntity->getName() !== Other::class) {
            return '';
        }

        return sprintf(
            '%s.language = %s',
            $targetTableAlias,
            $this->getParameter('language')
        );
    }
}
