<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=300)
     * @Assert\NotBlank
     * @Assert\Length(min = 4,
     *                minMessage = "Le nom de l'entreprise doit faire au moins {{ limit }} caractères."
     *)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=1500)
     * @Assert\NotBlank
     */
    private $activite;

    /**
     * @ORM\Column(type="string", length=500)
     * Assert\Url
     */
    private $lienSite;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="entreprise")
     */
    private $stages;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(?string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getLienSite(): ?string
    {
        return $this->lienSite;
    }

    public function setLienSite(string $lienSite): self
    {
        $this->lienSite = $lienSite;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }

        return $this;
    }
}
