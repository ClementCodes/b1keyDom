<?php

namespace App\Entity;

use App\Repository\LifePlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: LifePlaceRepository::class)]
class LifePlace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getPlaces"])]
    private ?int $id;

    #[ORM\Column(nullable: true)]
    #[Groups(["getPlaces"])]
    private ?int $pieces = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getPlaces"])]
    private ?int $bathroom = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getPlaces"])]
    private ?int $livingRoom = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getPlaces"])]
    private ?int $wc = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getPlaces"])]
    private ?int $rooms = null;

    #[Groups(["getPlaces"])]
    #[ORM\OneToMany(mappedBy: 'lifePlace', targetEntity: User::class)]
    private Collection $userLink;

    public function __construct()
    {
        $this->userLink = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPieces(): ?int
    {
        return $this->pieces;
    }

    public function setPieces(?int $pieces): self
    {
        $this->pieces = $pieces;

        return $this;
    }

    public function getBathroom(): ?int
    {
        return $this->bathroom;
    }

    public function setBathroom(?int $bathroom): self
    {
        $this->bathroom = $bathroom;

        return $this;
    }

    public function getLivingRoom(): ?int
    {
        return $this->livingRoom;
    }

    public function setLivingRoom(?int $livingRoom): self
    {
        $this->livingRoom = $livingRoom;

        return $this;
    }

    public function getWc(): ?int
    {
        return $this->wc;
    }

    public function setWc(?int $wc): self
    {
        $this->wc = $wc;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(?int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserLink(): Collection
    {
        return $this->userLink;
    }

    public function addUserLink(User $userLink): self
    {
        if (!$this->userLink->contains($userLink)) {
            $this->userLink->add($userLink);
            $userLink->setLife($this);
        }

        return $this;
    }

    public function removeUserLink(User $userLink): self
    {
        if ($this->userLink->removeElement($userLink)) {
            // set the owning side to null (unless already changed)
            if ($userLink->getLife() === $this) {
                $userLink->setLife(null);
            }
        }

        return $this;
    }
}
