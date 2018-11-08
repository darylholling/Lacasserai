<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\KamerRepository")
 */
class Kamer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $soortId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prijs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="kamerId")
     */
    private $images;


    public function __toString()
    {
     return $this->getSoortId() . '';
    }

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSoortId(): ?int
    {
        return $this->soortId;
    }

    public function setSoortId(int $soortId): self
    {
        $this->soortId = $soortId;

        return $this;
    }

    public function getPrijs(): ?string
    {
        return $this->prijs;
    }

    public function setPrijs(string $prijs): self
    {
        $this->prijs = $prijs;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setKamerId($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getKamerId() === $this) {
                $image->setKamerId(null);
            }
        }

        return $this;
    }
}
