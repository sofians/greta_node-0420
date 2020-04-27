<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="employe" ,
 *              indexes={@ORM\Index(name="ind_nom", columns={"nom"}),
 *                      @ORM\Index(name="ind_ville", columns={"ville"})
 *                       }
 *              )
 * @ORM\Entity(repositoryClass="App\Repository\EmployeRepository")
 */
class Employe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="decimal", precision=9, scale=2)
     */
    private $salaire;

    /**
     * @ORM\Column(name="ville", type="string", length=40, options={"default" = "Toulon"})
     */
    private $ville;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projet", inversedBy="employes")
     */
    private $projet;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Seminaire")
     * @ORM\JoinTable(
     *     name="inscrit",
     *     joinColumns={@ORM\JoinColumn(name="employe_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="seminaire_id", referencedColumnName="id")}
     *     )
     *
     */

    private $seminaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ObtenirCertification", mappedBy="employe_id", orphanRemoval=true)
     */
    private $certificationsObtenues;





    public function __construct()
    {
        $this->seminaires = new ArrayCollection();
        $this->certificationsObtenues = new ArrayCollection();
    }





    /**
     * @param Seminaire $seminaire
     * @return Employe
     */
    public  function addSeminaire(Seminaire $seminaire) : self {
        $this->seminaires[] = $seminaire;
        return $this;
    }

    /**
     * @param Seminaire $seminaire
     */
    public function removeSeminaire(Seminaire $seminaire) {
        $this->seminaires->removeElement($seminaire);
    }


    /**
     * @return Collection
     */
    public function getSemainaires() : Collection {
        return $this->seminaires;
    }

    public function getVille()
    {
        return $this->ville;
    }


    public function setVille($ville): self
    {
        $this->ville = $ville;
    }

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSalaire(): ?string
    {
        return $this->salaire;
    }

    public function setSalaire(string $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * @return Collection|ObtenirCertification[]
     */
    public function getCertificationsObtenues(): Collection
    {
        return $this->certificationsObtenues;
    }

    public function addCertificationsObtenue(ObtenirCertification $certificationsObtenue): self
    {
        if (!$this->certificationsObtenues->contains($certificationsObtenue)) {
            $this->certificationsObtenues[] = $certificationsObtenue;
            $certificationsObtenue->setEmployeId($this);
        }

        return $this;
    }

    public function removeCertificationsObtenue(ObtenirCertification $certificationsObtenue): self
    {
        if ($this->certificationsObtenues->contains($certificationsObtenue)) {
            $this->certificationsObtenues->removeElement($certificationsObtenue);
            // set the owning side to null (unless already changed)
            if ($certificationsObtenue->getEmployeId() === $this) {
                $certificationsObtenue->setEmployeId(null);
            }
        }

        return $this;
    }
}
