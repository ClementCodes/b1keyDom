<?php

namespace App\Entity;





use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\EntityListener\UserListener;
use Doctrine\ORM\Mapping\EntityListeners;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;


use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;




#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements
    UserInterface,
    PasswordAuthenticatedUserInterface

{
    #[Groups(["getUser"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(["getUser"])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(["getUser"])]
    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[Groups(["getUser"])]
    #[ORM\Column(length: 255)]
    private ?int $zipCode = null;


    #[Groups(["getUser"])]
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[Groups(["getUser"])]
    #[ORM\Column(length: 255)]
    private ?string $street = null;

    #[Groups(["getUser"])]
    #[ORM\Column(nullable: true)]
    private ?int $phone = null;


    #[Groups(["getUser"])]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateIn = null;

    #[Groups(["getUser"])]
    #[ORM\Column(nullable: true)]
    private array $roles = ["ROLE_USER"];

    #[Groups(["getUser"])]
    private ?string $plainPassword = null;


    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    #[Groups(["getUser"])]
    #[ORM\ManyToOne(inversedBy: 'userLink')]
    public ?LifePlace $lifePlace = null;

    public function __construct()
    {
        $this->dateIn = new \Datetime(); // Par défaut, la date de l'inscription est la date d'aujourd'hui
    }



    public function getId(): ?int
    {
        return $this->id;
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }






    /**
     * Méthode getUsername qui permet de retourner le champ qui est utilisé pour l'authentification.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }





    /**
     * Get the value of plainPassword
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }





    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }



    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }


    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDateIn(): ?\DateTimeInterface
    {
        return $this->dateIn;
    }

    public function setDateIn(\DateTimeInterface $dateIn): self
    {

        $this->dateIn = $dateIn;

        return $this;
    }



    public function getLife(): ?LifePlace
    {
        return $this->lifePlace;
    }

    public function setLife(?LifePlace $lifePlace): self
    {
        $this->lifePlace = $lifePlace;

        return $this;
    }
}
