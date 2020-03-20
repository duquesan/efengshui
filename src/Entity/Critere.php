<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CriteresRepository")
 */
class Criteres
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $nb_m_carre;

    /**
     * @ORM\Column(name="lieu", type="string", columnDefinition="enum('bureau', 'domicile')")
     */
    private $lieu;

    /**
     * @ORM\Column(type="integer")
     */
    private $annee_constr;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $plan_lieu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo_lieu;

    /**
     * @ORM\Column(type="boolean")
     */
    private $orientation;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $titre_diagnostic;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Diagnostic", mappedBy="criteres", cascade={"persist", "remove"})
     */
    private $diagnostic;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="criteres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

       
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbMCarre(): ?string
    {
        return $this->nb_m_carre;
    }

    public function setNbMCarre(string $nb_m_carre): self
    {
        $this->nb_m_carre = $nb_m_carre;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getAnneeConstr(): ?int
    {
        return $this->annee_constr;
    }

    public function setAnneeConstr(int $annee_constr): self
    {
        $this->annee_constr = $annee_constr;

        return $this;
    }

    public function getPlanLieu(): ?string
    {
        return $this->plan_lieu;
    }

    public function setPlanLieu(?string $plan_lieu): self
    {
        $this->plan_lieu = $plan_lieu;

        return $this;
    }

    public function getPhotoLieu(): ?string
    {
        return $this->photo_lieu;
    }

    public function setPhotoLieu(?string $photo_lieu): self
    {
        $this->photo_lieu = $photo_lieu;

        return $this;
    }

    public function getOrientation(): ?bool
    {
        return $this->orientation;
    }

    public function setOrientation(bool $orientation): self
    {
        $this->orientation = $orientation;

        return $this;
    }

    public function getTitreDiagnostic(): ?string
    {
        return $this->titre_diagnostic;
    }

    public function setTitreDiagnostic(string $titre_diagnostic): self
    {
        $this->titre_diagnostic = $titre_diagnostic;

        return $this;
    }


    public function getDiagnostic(): ?Diagnostic
    {
        return $this->diagnostic;
    }

    public function setDiagnostic(Diagnostic $diagnostic): self
    {
        $this->diagnostic = $diagnostic;

        // set the owning side of the relation if necessary
        if ($diagnostic->getCriteres() !== $this) {
            $diagnostic->setCriteres($this);
        }

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }
    
}