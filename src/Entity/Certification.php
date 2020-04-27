<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CertificationRepository")
 */
class Certification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $nomCertification;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ObtenirCertification", mappedBy="certification_id", orphanRemoval=true)
     */
    private $employesCertifies;

    public function __construct()
    {
        $this->employesCertifies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCertification(): ?string
    {
        return $this->nomCertification;
    }

    public function setNomCertification(string $nomCertification): self
    {
        $this->nomCertification = $nomCertification;

        return $this;
    }

    /**
     * @return Collection|ObtenirCertification[]
     */
    public function getEmployesCertifies(): Collection
    {
        return $this->employesCertifies;
    }

    public function addEmployesCertify(ObtenirCertification $employesCertify): self
    {
        if (!$this->employesCertifies->contains($employesCertify)) {
            $this->employesCertifies[] = $employesCertify;
            $employesCertify->setCertificationId($this);
        }

        return $this;
    }

    public function removeEmployesCertify(ObtenirCertification $employesCertify): self
    {
        if ($this->employesCertifies->contains($employesCertify)) {
            $this->employesCertifies->removeElement($employesCertify);
            // set the owning side to null (unless already changed)
            if ($employesCertify->getCertificationId() === $this) {
                $employesCertify->setCertificationId(null);
            }
        }

        return $this;
    }
}
