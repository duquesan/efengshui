<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $mdp;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut_user;

    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Diagnostic", mappedBy="user", orphanRemoval=true)
     */
    private $diagnostics;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Criteres", mappedBy="user", orphanRemoval=true)
     */
    private $criteres;

    public function __construct()
    {
        $this->diagnostic = new ArrayCollection();
        $this->diagnostics = new ArrayCollection();
        $this->criteres = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getStatutUser(): ?bool
    {
        return $this->statut_user;
    }

    public function setStatutUser(bool $statut_user): self
    {
        $this->statut_user = $statut_user;

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
            $diagnostic->setUser($this);
        }

        return $this;
    }

    public function removeDiagnostic(Diagnostic $diagnostic): self
    {
        if ($this->diagnostics->contains($diagnostic)) {
            $this->diagnostics->removeElement($diagnostic);
            // set the owning side to null (unless already changed)
            if ($diagnostic->getUser() === $this) {
                $diagnostic->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Criteres[]
     */
    public function getCriteres(): Collection
    {
        return $this->criteres;
    }

    public function addCritere(Criteres $critere): self
    {
        if (!$this->criteres->contains($critere)) {
            $this->criteres[] = $critere;
            $critere->setUser($this);
        }

        return $this;
    }

    public function removeCritere(Criteres $critere): self
    {
        if ($this->criteres->contains($critere)) {
            $this->criteres->removeElement($critere);
            // set the owning side to null (unless already changed)
            if ($critere->getUser() === $this) {
                $critere->setUser(null);
            }
        }

        return $this;
    }

}
