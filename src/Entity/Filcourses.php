<?php

namespace App\Entity;

use App\Repository\FilcoursesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FilcoursesRepository::class)
 */
class Filcourses
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $num;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $filiere;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $succ;

    /**
     * @ORM\Column(type="integer")
     */
    private $prec;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): self
    {
        $this->num = $num;

        return $this;
    }

    public function getFiliere(): ?string
    {
        return $this->filiere;
    }

    public function setFiliere(string $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getSucc(): ?string
    {
        return $this->succ;
    }

    public function setSucc(string $succ): self
    {
        $this->succ = $succ;

        return $this;
    }

    public function getPrec(): ?int
    {
        return $this->prec;
    }

    public function setPrec(int $prec): self
    {
        $this->prec = $prec;

        return $this;
    }
}
