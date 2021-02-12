<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"email"}, message="un autre utilisateur s'est deja inscrit avec cette adresse email, merci de la modifier")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="vous devez renseigner votre prénom")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="vous devez renseigner votre nom de famille")
     */
    private $lastName;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="votre email doit etre valide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(message="veuillez donner un Url valide pour votre avatar")
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;
    /**
     * @Assert\EqualTo(propertyPath="hash", message="vous n'avez pas correctement confirmé votre mot de passe")
     */
    public $passwordconfirm;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10, minMessage="votre introduction doit faire au moins 10 carateres")
     */
    private $introduction;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min= 100, minMessage="votre description doit faire au moins 100 caracteres")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Ad::class, mappedBy="Author")
     */
    private $ads;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="users")
     */
    private $userRoles;



    /**
     * @ORM\OneToMany(targetEntity=Booking1::class, mappedBy="booker")
     */
    private $booking1s;






    public function getfullName()
    {
        return "{$this->firstName}{$this->lastName}";
    }

    /**
     * Callback appélé à chaque fois qu'on affiche une annonce
     */
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function initializeSlug()
    {
        $slugify = new Slugify();
        if (empty($this->slug)) {
            $this->slug = $slugify->slugify($this->firstName . ' ' . $this->lastName);
        }
    }

    public function __construct()
    {
        $this->ads = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
        $this->role1s = new ArrayCollection();
        $this->userRoles2 = new ArrayCollection();

        $this->booking1s = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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

    /**
     * @return Collection|Ad[]
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }


    public function addAd(Ad $ad): self
    {
        if (!$this->ads->contains($ad)) {
            $this->ads[] = $ad;
            $ad->setAuthor($this);
        }

        return $this;
    }

    public function removeAd(Ad $ad): self
    {
        if ($this->ads->removeElement($ad)) {
            // set the owning side to null (unless already changed)
            if ($ad->getAuthor() === $this) {
                $ad->setAuthor(null);
            }
        }

        return $this;
    }

    public function getRoles()

    {
        //$roles=$this->userRoles->toArray();
       // dump($roles);
        $roles=$this->userRoles->map(function ($role){
      return $role->getTitle();
        })->toArray();
        //
        $roles[]= 'ROLE_USER';
        return $roles;






        // TODO: Implement getRoles() method.
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        // TODO: Implement getPassword() method.
        return $this->hash;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        // TODO: Implement getUsername() method.
        return $this->email;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(Role $userRole): self
    {
        if ($this->userRoles->removeElement($userRole)) {
            $userRole->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Booking1[]
     */
    public function getBooking1s(): Collection
    {
        return $this->booking1s;
    }

    public function addBooking1(Booking1 $booking1): self
    {
        if (!$this->booking1s->contains($booking1)) {
            $this->booking1s[] = $booking1;
            $booking1->setBooker($this);
        }

        return $this;
    }

    public function removeBooking1(Booking1 $booking1): self
    {
        if ($this->booking1s->removeElement($booking1)) {
            // set the owning side to null (unless already changed)
            if ($booking1->getBooker() === $this) {
                $booking1->setBooker(null);
            }
        }

        return $this;
    }

















}










