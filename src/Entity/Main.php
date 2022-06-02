<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Main
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Other", inversedBy="mains", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="main_other")
     *
     * @var Other[]|Collection
     */
    private $others;

    public function __construct()
    {
        $this->others = new ArrayCollection();
    }

    public function addOther(Other $other): void
    {
        if ($this->others->contains($other)) {
            return;
        }

        $this->others->add($other);
        $other->addMain($this);
    }

    /**
     * @return Other[]
     */
    public function getOthers(): array
    {
        return $this->others->toArray();
    }
}
