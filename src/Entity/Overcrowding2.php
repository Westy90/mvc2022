<?php

namespace App\Entity;

use App\Repository\Overcrowding2Repository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Overcrowding2Repository::class)]
class Overcrowding2
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'integer')]
    private $year;

    #[ORM\Column(type: 'float', nullable: true)]
    private $percentage;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $norm;


    /**
     * Constructor to create a Overcrowding.
     *
     * @param string $type              Type of meassurment
     * @param int    $year              What year the data is from
     * @param float    $percentage        How much overcrowding
     * @param int    $norm              What norm was used
     */
    public function __construct(
        string $type,
        int $year,
        ?float $percentage = null,
        ?int $norm = null,
    ) {
        $this->type = $type;
        $this->year = $year;
        $this->percentage = $percentage;
        $this->norm = $norm;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getPercentage(): ?float
    {
        return $this->percentage;
    }

    public function setPercentage(?float $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }

    public function getNorm(): ?int
    {
        return $this->norm;
    }

    public function setNorm(?int $norm): self
    {
        $this->norm = $norm;

        return $this;
    }
}
