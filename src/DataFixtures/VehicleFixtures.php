<?php

namespace App\DataFixtures;

use App\Entity\Vehicle;
use App\Entity\TypeVehicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VehicleFixtures extends Fixture
{
    private array $vehicles = [
        [
            'id' => 1,
            'image' => 'img/vehicle2.jpg',
            'name' => 'Honda Civic',
            'type' => 'Berline',
            'capacity' => 5,
            'price' => 45,
        ],
        [
            'id' => 2,
            'image' => 'img/vehicle3.jpg',
            'name' => 'Ford Escape',
            'type' => 'SUV',
            'capacity' => 5,
            'price' => 55,
        ],
        [
            'id' => 3,
            'image' => 'img/vehicle4.jpg',
            'name' => 'Chevrolet Impala',
            'type' => 'Berline',
            'capacity' => 5,
            'price' => 48,
        ],
        [
            'id' => 4,
            'image' => 'img/vehicle5.jpg',
            'name' => 'Jeep Wrangler',
            'type' => 'VUS tout-terrain',
            'capacity' => 4,
            'price' => 60,
        ],
        [
            'id' => 5,
            'image' => 'img/vehicle6.jpg',
            'name' => 'Ford Mustang',
            'type' => 'Cabriolet',
            'capacity' => 2,
            'price' => 70,
        ],
        [
            'id' => 6,
            'image' => 'img/vehicle7.jpg',
            'name' => 'Nissan Rogue',
            'type' => 'SUV',
            'capacity' => 5,
            'price' => 58,
        ],
        [
            'id' => 7,
            'image' => 'img/vehicle8.jpg',
            'name' => 'Hyundai Elantra',
            'type' => 'Berline',
            'capacity' => 5,
            'price' => 42,
        ],
        [
            'id' => 8,
            'image' => 'img/vehicle9.jpg',
            'name' => 'Subaru Outback',
            'type' => 'VUS',
            'capacity' => 5,
            'price' => 52,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->vehicles as $data) {
            // Créer le type de véhicule à partir du champ "type"
            $typeVehicle = new TypeVehicle();
            $typeVehicle->setName($data['type']);
            $manager->persist($typeVehicle);

            $vehicle = new Vehicle();
            $vehicle->setImage($data['image'])
                    ->setName($data['name'])
                    ->setTypeVehicle($typeVehicle)
                    ->setCapacity($data['capacity'])
                    ->setPrice($data['price']);
            $manager->persist($vehicle);
        }
        $manager->flush();
    }
}
