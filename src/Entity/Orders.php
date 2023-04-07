<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $orderCode = null;

    #[ORM\Column]
    private ?int $productid = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $address = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private \DateTimeInterface|null $shippingDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderCode(): ?string
    {
        return $this->orderCode;
    }

    public function setOrderCode(string $orderCode): self
    {
        $this->orderCode = $orderCode;

        return $this;
    }

    public function getProductid(): ?int
    {
        return $this->productid;
    }

    public function setProductid(int $productid): self
    {
        $this->productid = $productid;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getShippingDate(): \DateTimeInterface|null
    {
        return $this->shippingDate;
    }

    public function setShippingDate(?\DateTimeInterface $shippingDate): self
    {
        $this->shippingDate = $shippingDate;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'orderCode' => $this->getOrderCode(),
            'productid' => $this->getProductid(),
            'quantity' => $this->getQuantity(),
            'address' => $this->getAddress(),
            'shippingDate' => $this->getShippingDate()
        ];
    }
}
