<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Other
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
     * @ORM\ManyToMany(targetEntity="Main", mappedBy="others", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="main_other")
     *
     * @var Collection|[]
     */
    private $mains;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $language;

    public function __construct(string $name, string $language)
    {
        $this->name = $name;
        $this->language = $language;
        $this->mains = new ArrayCollection();
    }

    public function addMain(Main $main): void
    {
        if ($this->mains->contains($main)) {
            return;
        }
        $this->mains->add($main);
        $main->addOther($this);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }
}
