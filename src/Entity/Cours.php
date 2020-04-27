<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursRepository")
 */
class Cours
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="libelleCours", type="string", length=40)
     */
    private $libelleCours;

    /**
     *
     * @ORM\Column(name="nbJours", type="integer")
     */
    private $nbJours;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Seminaire", mappedBy="cours")
     */
    private $seminaires;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Theme", inversedBy="lesCours")
     * @ORM\JoinTable(
     *     name="CoursTheme",
     *     joinColumns={@ORM\JoinColumn(name="cours_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="theme_id", referencedColumnName="id")}
     *     )
     */
    private $lesThemes;



    public function __construct()
    {

        $this->seminaires = new ArrayCollection();
        $this->lesThemes = new ArrayCollection();
    }


    public function getLesThemes() {
        return $this->lesThemes;
    }

    public function addTheme(Theme $theme) {
        $this->lesThemes[] = $theme;
        return $this;
    }

    public function removeTheme(Theme $theme) : self {
        $this->lesThemes->removeElement($theme);
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCours(): ?string
    {
        return $this->libelleCours;
    }

    public function setLibelleCours(string $libelleCours): self
    {
        $this->libelleCours = $libelleCours;

        return $this;
    }

    public function getNbJours(): ?int
    {
        return $this->nbJours;
    }

    public function setNbJours(int $nbJours): self
    {
        $this->nbJours = $nbJours;

        return $this;
    }

    /**
     * @return Collection|Seminaire[]
     */
    public function getSeminaires(): Collection
    {
        return $this->seminaires;
    }

    public function addSeminaire(Seminaire $seminaire): self
    {
        if (!$this->seminaires->contains($seminaire)) {
            $this->seminaires[] = $seminaire;
            $seminaire->setCours($this);
        }

        return $this;
    }

    public function removeSeminaire(Seminaire $seminaire): self
    {
        if ($this->seminaires->contains($seminaire)) {
            $this->seminaires->removeElement($seminaire);
            // set the owning side to null (unless already changed)
            if ($seminaire->getCours() === $this) {
                $seminaire->setCours(null);
            }
        }

        return $this;
    }
}
