<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=StageRepository::class)
 */
class Stage
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
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=10000)
     * @Assert\NotBlank
     */
    private $mission;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity=Formation::class, inversedBy="stages")
     * @Assert\Count(min = 1,
     *               minMessage = "Vous devez choisir au minimun {{ limit }} stage.")
     */
    private $typeFormation;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Assert\Valid
     */
    private $entreprise;

    /**
     * @ORM\Column(type="string", length=300)
     * @Gedmo\Slug(fields={"titre"})
     */
    private $slug;

    public function __construct()
    {
        $this->typeFormation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getMission(): ?string
    {
        return $this->mission;
    }

    public function setMission(string $mission): self
    {
        $this->mission = $mission;

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

    /**
     * @return Collection|Formation[]
     */
    public function getTypeFormation(): Collection
    {
        return $this->typeFormation;
    }

    public function addTypeFormation(Formation $typeFormation): self
    {
        if (!$this->typeFormation->contains($typeFormation)) {
            $this->typeFormation[] = $typeFormation;
        }

        return $this;
    }

    public function removeTypeFormation(Formation $typeFormation): self
    {
        $this->typeFormation->removeElement($typeFormation);

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function __toString(){
        return $this->getTitre();
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
