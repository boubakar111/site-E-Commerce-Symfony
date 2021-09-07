<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $transproteurName;

    /**
     * @ORM\Column(type="float")
     */
    private $transportPrice;

    /**
     * @ORM\Column(type="text")
     */
    private $adresseLivraison;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPaid = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $moreInformations;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=OrderDetaiils::class, mappedBy="orders")
     */
    private $orderDetaiils;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="float")
     */
    private $subTotalHT;

    /**
     * @ORM\Column(type="float")
     */
    private $taxe;

    /**
     * @ORM\Column(type="float")
     */
    private $subTotalTTC;

    public function __construct()
    {
        $this->orderDetaiils = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getTransproteurName(): ?string
    {
        return $this->transproteurName;
    }

    public function setTransproteurName(string $transproteurName): self
    {
        $this->transproteurName = $transproteurName;

        return $this;
    }

    public function getTransportPrice(): ?float
    {
        return $this->transportPrice;
    }

    public function setTransportPrice(float $transportPrice): self
    {
        $this->transportPrice = $transportPrice;

        return $this;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(string $adresseLivraison): self
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    public function getIsPaider(): ?bool
    {
        return $this->isPaider;
    }

    public function setIsPaider(bool $isPaider): self
    {
        $this->isPaider = $isPaider;

        return $this;
    }

    public function getMoreInformations(): ?string
    {
        return $this->moreInformations;
    }

    public function setMoreInformations(?string $moreInformations): self
    {
        $this->moreInformations = $moreInformations;

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

    /**
     * @return Collection|OrderDetaiils[]
     */
    public function getOrderDetaiils(): Collection
    {
        return $this->orderDetaiils;
    }

    public function addOrderDetaiil(OrderDetaiils $orderDetaiil): self
    {
        if (!$this->orderDetaiils->contains($orderDetaiil)) {
            $this->orderDetaiils[] = $orderDetaiil;
            $orderDetaiil->setOrders($this);
        }

        return $this;
    }

    public function removeOrderDetaiil(OrderDetaiils $orderDetaiil): self
    {
        if ($this->orderDetaiils->removeElement($orderDetaiil)) {
            // set the owning side to null (unless already changed)
            if ($orderDetaiil->getOrders() === $this) {
                $orderDetaiil->setOrders(null);
            }
        }

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getSubTotalHt(): ?float
    {
        return $this->subTotalHt;
    }

    public function setSubTotalHt(float $subTotalHt): self
    {
        $this->subTotalHt = $subTotalHt;

        return $this;
    }

    public function getTaxe(): ?float
    {
        return $this->taxe;
    }

    public function setTaxe(float $taxe): self
    {
        $this->taxe = $taxe;

        return $this;
    }

    public function getSubTotalTTC(): ?float
    {
        return $this->subTotalTTC;
    }

    public function setSubTotalTTC(float $subTotalTTC): self
    {
        $this->subTotalTTC = $subTotalTTC;

        return $this;
    }
}
