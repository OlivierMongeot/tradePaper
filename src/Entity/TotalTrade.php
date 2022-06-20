<?php

namespace App\Entity;

use App\Repository\TotalTradeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TotalTradeRepository::class)
 */
class TotalTrade
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
    private $token;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $sell;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $buy;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $balance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getSell(): ?float
    {
        return $this->sell;
    }

    public function setSell(?float $sell): self
    {
        $this->sell = $sell;

        return $this;
    }

    public function getBuy(): ?float
    {
        return $this->buy;
    }

    public function setBuy(?float $buy): self
    {
        $this->buy = $buy;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(?float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

  


}
