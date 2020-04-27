<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="obtenirCertification" ,
 *     indexes={
 *              @ORM\Index(name="employe_id", columns={"employe_id"}),
 *              @ORM\Index(name="certification_id", columns={"certification_id"})
 *              },
 *      uniqueConstraints = {@ORM\UniqueConstraint(name="UnEmployeCertification", columns={"Employe_id", "certification_id"})}
 *     )
 * @ORM\Entity(repositoryClass="App\Repository\ObtenirCertificationRepository")
 */
class ObtenirCertification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateObtention;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employe", inversedBy="certificationsObtenues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Certification", inversedBy="employesCertifies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $certification;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateObtention(): ?\DateTimeInterface
    {
        return $this->dateObtention;
    }

    public function setDateObtention(\DateTimeInterface $dateObtention): self
    {
        $this->dateObtention = $dateObtention;

        return $this;
    }

    public function getEmploye(): ?Employe
    {
        return $this->employe;
    }

    public function setEmploye(?Employe $employe): self
    {
        $this->employe_id = $employe;

        return $this;
    }

    public function getCertification(): ?Certification
    {
        return $this->certification;
    }

    public function setCertificationId(?Certification $certification): self
    {
        $this->certification = $certification;

        return $this;
    }
}
