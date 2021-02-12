<?php

namespace App\Entity;

use App\Repository\AdRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AdRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *fields={"title"},
 * message="une autre annonce possede deja ce titre, merci de le modifier"
 * )
 */
class Ad
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10, max=255, minMessage="le titre doit faire plus de 10 caractere", maxMessage="le titre ne peut pas faire plus de 255 caratere")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=20, max=255, minMessage="l'introduction doit faire plus de 20 caractere", maxMessage="pas plus de 255")
     */
    private $introduction;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=100, max=255, minMessage="la description doit faire plus de 100 caractere", maxMessage="pas plus de 255 caractere")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url()
     */
    private $coverImage;

    /**
     * @ORM\Column(type="integer")
     */
    private $rooms;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="ad", orphanRemoval=true)
     * @Assert\Valid()
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Author;



    /**
     * @ORM\OneToMany(targetEntity=Booking1::class, mappedBy="ad")
     */
    private $booking1s;





    public function __construct()
    {
        $this->images = new ArrayCollection();

        $this->booking1s = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function initializeSlug()
    {$slugify= new Slugify();
        if(empty($this->slug))
        {
            $this->slug= $slugify->slugify($this->title);
        }
    }

    /**
     * permet d'obtenir un tableau des jours qui ne sont pas disponibles pour l'annonce
     */
    public function getNotAvaillableDays()
    {
        $notAvaillableDays = [];


        foreach ($this->booking1s as $booking1){
            // calculer les jours qui se trouve  entre la date d'arriver et la date de depart
            $resultat= range($booking1->getStartDate()->getTimestamp(),$booking1->getEndDate()->getTimestamp(),
                24*60*60);



            $days = array_map(function ($dayTimestamp){

                return new \DateTime(date('Y-m-d', $dayTimestamp));
            }, $resultat);

$notAvaillableDays= array_merge($notAvaillableDays, $days);
        }
        return $notAvaillableDays;

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

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
            $image->setAd($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAd() === $this) {
                $image->setAd(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->Author;
    }

    public function setAuthor(?User $Author): self
    {
        $this->Author = $Author;

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
            $booking1->setAd($this);
        }

        return $this;
    }

    public function removeBooking1(Booking1 $booking1): self
    {
        if ($this->booking1s->removeElement($booking1)) {
            // set the owning side to null (unless already changed)
            if ($booking1->getAd() === $this) {
                $booking1->setAd(null);
            }
        }

        return $this;
    }


















}
