<?php

namespace App\Entity;

use App\Repository\CourstdRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourstdRepository::class)
 */
class Courstd
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $matiere;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $anesem;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

   
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getAnesem(): ?string
    {
        return $this->anesem;
    }

    public function setAnesem(string $anesem): self
    {
        $this->anesem = $anesem;

        return $this;
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
}
