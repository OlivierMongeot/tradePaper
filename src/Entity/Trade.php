<?php

namespace App\Entity;

use App\Repository\TradeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TradeRepository::class)
 */
class Trade
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="trades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

    /**
     * @ORM\ManyToOne(targetEntity=Token::class, inversedBy="trades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $token;

    /**
     * @ORM\Column(type="float")
     */
    private $token_price_transaction;

    /**
     * @ORM\Column(type="float")
     */
    private $quantity;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $fee;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="trades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Exchange::class, inversedBy="trades")
     */
    private $exchange;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $order_mount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $note;

  

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $IdBuyTransaction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(?Action $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getToken(): ?Token
    {
        return $this->token;
    }

    public function setToken(?Token $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getTokenPriceTransaction(): ?float
    {
        return $this->token_price_transaction;
    }

    public function setTokenPriceTransaction(float $token_price_transaction): self
    {
        $this->token_price_transaction = $token_price_transaction;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getFee(): ?float
    {
        return $this->fee;
    }

    public function setFee(?float $fee): self
    {
        $this->fee = $fee;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getExchange(): ?Exchange
    {
        return $this->exchange;
    }

    public function setExchange(?Exchange $exchange): self
    {
        $this->exchange = $exchange;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getOrderMount(): ?float
    {
        return $this->order_mount;
    }

    public function setOrderMount(?float $order_mount): self
    {
        $this->order_mount = $order_mount;

        return $this;
    }

    public function getNote(): ?string
    {   
        $note = strip_tags($this->note);
        $note = str_replace("&nbsp;", "", $note);
        return $note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getFullMount(): ?float
    {
        return $this->getQuantity() * $this->getTokenPriceTransaction();
    }

    public function getQty(): ?string
    {
        return $this->qty;
    }

    public function setQty(string $qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    public function getIdBuyTransaction(): ?int
    {
        return $this->IdBuyTransaction;
    }

    public function setIdBuyTransaction(?int $IdBuyTransaction): self
    {
        $this->IdBuyTransaction = $IdBuyTransaction;

        return $this;
    }

 


}
