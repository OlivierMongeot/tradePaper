<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TokenRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=TokenRepository::class)
 * @Vich\Uploadable
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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file;

    /**
     * @Vich\UploadableField(mapping="token_images", fileNameProperty="file")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $randomNumber;

    // /**
    //  * @ORM\Column(type="date", nullable=true)
    //  * @var \Date
    //  */
    // private $updated_at;


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

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }

    

    /**
     * Get the value of imageFile
     *
     * @return  File
     */ 
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @param  File  $imageFile
     *
     * @return  self
     */ 
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    // public function getUpdatedAt()
    //     {
    //     return $this->updated_at;
    // }

    // public function setUpdatedAt($updated_at): self
    // {
    //     $this->updated_at = $updated_at;

    //     return $this;
    // }

    public function getRandomNumber(): ?float
    {
        return rand(0, 100);
    }

    public function setRandomNumber(?float $randomNumber): self
    {
        // create a random number between 0 and 100
        $this->randomNumber = rand(0, 100);
        return $this;
    }


}
