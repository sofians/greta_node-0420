<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ThemeRepository")
 */
class Theme
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $libelle;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Cours", mappedBy="lesThemes")
     */
    private $lesCours;


    public function __construct()
    {
        $this->lesCours = new ArrayCollection();
    }

    public function getCours() : Collection {
        return $this->lesCours;
    }

    public function addCours(Cours $cours) :self {
        $this->lesCours[] = $cours;
        return $this;
    }

    public function removeCours(Cours $cours) :self {
        $this->lesCours->removeElement($cours);
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }
}
