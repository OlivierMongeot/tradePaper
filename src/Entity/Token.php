<?php

namespace App\Entity;

use App\Repository\TokenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TokenRepository::class)
 */
class Token
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Trade::class, mappedBy="token")
     */
    private $trades;

    /**
     * @ORM\OneToMany(targetEntity=Configuration::class, mappedBy="token")
     */
    private $exchange;

    public function __construct()
    {
        $this->trades = new ArrayCollection();
        $this->exchange = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Trade>
     */
    public function getTrades(): Collection
    {
        return $this->trades;
    }

    public function addTrade(Trade $trade): self
    {
        if (!$this->trades->contains($trade)) {
            $this->trades[] = $trade;
            $trade->setToken($this);
        }

        return $this;
    }

    public function removeTrade(Trade $trade): self
    {
        if ($this->trades->removeElement($trade)) {
            // set the owning side to null (unless already changed)
            if ($trade->getToken() === $this) {
                $trade->setToken(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Configuration>
     */
    public function getExchange(): Collection
    {
        return $this->exchange;
    }

    public function addExchange(Configuration $exchange): self
    {
        if (!$this->exchange->contains($exchange)) {
            $this->exchange[] = $exchange;
            $exchange->setToken($this);
        }

        return $this;
    }

    public function removeExchange(Configuration $exchange): self
    {
        if ($this->exchange->removeElement($exchange)) {
            // set the owning side to null (unless already changed)
            if ($exchange->getToken() === $this) {
                $exchange->setToken(null);
            }
        }

        return $this;
    }
}
