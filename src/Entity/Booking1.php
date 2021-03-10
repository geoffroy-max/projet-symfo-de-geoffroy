<?php

namespace App\Entity;

use App\Repository\Booking1Repository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=Booking1Repository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Booking1
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="booking1s")
     * @ORM\JoinColumn(nullable=false)
     */
    private $booker;

    /**
     * @ORM\ManyToOne(targetEntity=Ad::class, inversedBy="booking1s")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ad;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Type("\Datetime")
     * @Assert\NotBlank(message="la date de construction ne peut pas etre vide")
     * @Assert\GreaterThan("today",message="la date d'arrivée doit etre ulterieure que celle d'aujourd'hui!",
     *      groups={"front"})
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Type("\Datetime")
     * @Assert\NotBlank(message="la date de construction ne peut pas etre vide")
     * @Assert\GreaterThan(propertyPath="startDate", message="la date de depart doit etre plus eloignée que celle d'arrivée")
     */
    private $endDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;
    /**
     * Callback appélé à chaque fois qu'on réserve une annonce ou à chak fois on la mise à jour
     */
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function prepersist()
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
        if (empty($this->amount)) {
            // prix de l'annonce*nombres des jours
            $this->amount = $this->ad->getPrice() * $this->getDuration();
        }
    }

    //  on creer une fonction   pour savoir est ce que ces dates sont possibles

    public function isBookableDate()
    {
        // 1) il faut connaitre les dates qui sont impossible pour l'annonce
        $notAvaillableDays = $this->ad->getNotAvaillableDays();
        // 2) il faut comparer les dates choisies avec les dates impossibles
        $bookingdays = $this->getDays();

        //pour eviter de dupliquer le code on le stocke dans formatadays

        $formatDays = function ($day) {

            return $day->format('Y-m-d');
        };

        //convertir le tableaux en chaines de caractere (de journée possible et impossible pour bien  les comparer)

        $days = array_map($formatDays, $bookingdays);

        $notAvaillable = array_map($formatDays, $notAvaillableDays);

        foreach ($days as $day) {
            if (array_search($day, $notAvaillable) !== false) return false;
        }
        return true;
    }

    /**
     * permet de recuperer un tableau  des journées qui corespondent à ma reservation
     */
    public function getDays()
    {

        $resultat = range($this->getStartDate()->getTimestamp(), $this->getEndDate()->getTimestamp(),
            24 * 60 * 60);
    foreach ($resultat as $kk) {

    $days = array_map(function ($dayTimestamp) {

        return new \DateTime(date('Y-m-d', $dayTimestamp));
    }, $resultat);

      }return $days;
     }

    public function getDuration()
    {
        $diff= $this->endDate->diff($this->startDate);
        return $diff->days;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBooker(): ?User
    {
        return $this->booker;
    }

    public function setBooker(?User $booker): self
    {
        $this->booker = $booker;

        return $this;
    }

    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(?Ad $ad): self
    {
        $this->ad = $ad;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
