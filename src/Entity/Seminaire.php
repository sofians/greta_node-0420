<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeminaireRepository")
 */
class Seminaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="dateDebutSeminaire", type="date")
     */
    private $dateDebutSeminaire;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Employe", mappedBy="seminaires")
     */
    private $employes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cours", inversedBy="seminaires")
     */
    private $cours;

    public function __construct() {
        $this->employes = new ArrayCollection();
    }


    /**
     * @param Employe $employe
     * @return Seminaire
     */
    public function addEmploye(Employe $employe) :self {
        $this->employes[] = $employe;
        return $this;
    }

    /**
     * @param Employe $employe
     */
    public function removeEmploye(Employe $employe) {
        $this->employes->removeElement($employe);

    }

    public function getEmployes() : Collection {
        return $this->employes;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebutSeminaire(): ?\DateTimeInterface
    {
        return $this->dateDebutSeminaire;
    }

    public function setDateDebutSeminaire(\DateTimeInterface $dateDebutSeminaire): self
    {
        $this->dateDebutSeminaire = $dateDebutSeminaire;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        $this->cours = $cours;

        return $this;
    }
}
