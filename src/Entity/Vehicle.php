<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\TypeVehicle;

#[ORM\Entity]
#[ORM\Table(name: 'vehicle')]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: TypeVehicle::class)]
    #[ORM\JoinColumn(nullable: true)] // Passage à nullable pour éviter l'erreur sur les données existantes
    private ?TypeVehicle $typeVehicle = null;

    #[ORM\Column(type: 'integer')]
    private ?int $capacity = null;

    #[ORM\Column(type: 'integer')]
    private ?int $price = null;

    // ...existing getters/setters...

    public function getId(): ?int 
    {
        return $this->id;
    }
    
    public function getImage(): ?string 
    {
        return $this->image;
    }
    public function setImage(string $image): self 
    {
        $this->image = $image;
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

    public function getTypeVehicle(): ?TypeVehicle
    {
        return $this->typeVehicle;
    }
    public function setTypeVehicle(TypeVehicle $typeVehicle): self
    {
        $this->typeVehicle = $typeVehicle;
        return $this;
    }
    
    public function getCapacity(): ?int 
    {
        return $this->capacity;
    }
    public function setCapacity(int $capacity): self 
    {
        $this->capacity = $capacity;
        return $this;
    }
    
    public function getPrice(): ?int 
    {
        return $this->price;
    }
    public function setPrice(int $price): self 
    {
        $this->price = $price;
        return $this;
    }
}
