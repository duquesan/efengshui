<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiagnosticRepository")
 */
class Diagnostic
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
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut_paiement;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $expertise;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut_expertise;

   
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="diagnostics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\criteres", inversedBy="diagnostic", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $criteres;

    
    public function __construct()
    {
        $this->diagnostics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatutPaiement(): ?bool
    {
        return $this->statut_paiement;
    }

    public function setStatutPaiement(bool $statut_paiement): self
    {
        $this->statut_paiement = $statut_paiement;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getExpertise(): ?string
    {
        return $this->expertise;
    }

    public function setExpertise(?string $expertise): self
    {
        $this->expertise = $expertise;

        return $this;
    }

    public function getStatutExpertise(): ?bool
    {
        return $this->statut_expertise;
    }

    public function setStatutExpertise(bool $statut_expertise): self
    {
        $this->statut_expertise = $statut_expertise;

        return $this;
    }

    
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Diagnostic[]
     */
    public function getDiagnostics(): Collection
    {
        return $this->diagnostics;
    }

    public function addDiagnostic(Diagnostic $diagnostic): self
    {
        if (!$this->diagnostics->contains($diagnostic)) {
            $this->diagnostics[] = $diagnostic;
            $diagnostic->setCriteres($this);
        }

        return $this;
    }

    public function removeDiagnostic(Diagnostic $diagnostic): self
    {
        if ($this->diagnostics->contains($diagnostic)) {
            $this->diagnostics->removeElement($diagnostic);
            // set the owning side to null (unless already changed)
            if ($diagnostic->getCriteres() === $this) {
                $diagnostic->setCriteres(null);
            }
        }

        return $this;
    }

    public function getCriteres(): ?criteres
    {
        return $this->criteres;
    }

    public function setCriteres(criteres $criteres): self
    {
        $this->criteres = $criteres;

        return $this;
    }
}
