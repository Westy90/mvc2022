<?php

namespace App\Entity;

use App\Repository\TrainLibraryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainLibraryRepository::class)]
class TrainLibrary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $amount_made;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $year_made;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $last_year_made;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $exit_service;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $picture;

    /**
     * Constructor to create a Train.
     *
     * @param string $name The name of train.
     * @param int    $age  The age of the person.
     */
    public function __construct( 
        string $name,
        ?int $amount_made = NULL,
        ?int $year_made = NULL,
        ?int $last_year_made = NULL,
        ?int $exit_service = NULL,
        ?string $picture = NULL
    )
    {
        $this->name = $name;
        $this->amount_made = $amount_made;
        $this->year_made = $year_made;
        $this->last_year_made = $last_year_made;
        $this->exit_service = $exit_service;
        $this->picture = $picture;
    }

    public function getDataArray(): array
    {
        return [$this->name, $this->amount_made, $this->year_made, $this->last_year_made, $this->exit_service];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAmountMade(): ?int
    {
        return $this->amount_made;
    }

    public function setAmountMade(?int $amount_made): self
    {
        $this->amount_made = $amount_made;

        return $this;
    }

    public function getYearMade(): ?int
    {
        return $this->year_made;
    }

    public function setYearMade(?int $year_made): self
    {
        $this->year_made = $year_made;

        return $this;
    }

    public function getLastYearMade(): ?int
    {
        return $this->last_year_made;
    }

    public function setLastYearMade(?int $last_year_made): self
    {
        $this->last_year_made = $last_year_made;

        return $this;
    }

    public function getExitService(): ?int
    {
        return $this->exit_service;
    }

    public function setExitService(?int $exit_service): self
    {
        $this->exit_service = $exit_service;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}
