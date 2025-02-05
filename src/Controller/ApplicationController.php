<?php

namespace App\Controller;

use App\Entity\Vehicle;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ApplicationController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function accueilMethod(): Response
    {
        return $this->render('application/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/vehicules', name: 'app_vehicles')]
    public function vehicles(ManagerRegistry $doctrine): Response
    {
        $vehicles = $doctrine->getRepository(Vehicle::class)->findAll();
        return $this->render('application/vehicles.html.twig', [
            'vehicules' => $vehicles,
        ]);
    }

    #[Route('/reserve/{id}', name: 'app_reserve')]
    public function reserve(ManagerRegistry $doctrine, $id): Response
    {
        $vehicule = $doctrine->getRepository(Vehicle::class)->find($id);
        if (!$vehicule) {
            throw $this->createNotFoundException('Vehicle not found');
        }
        return $this->render('application/reservation.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    #[Route('/details/{id}', name: 'app_details')]
    public function details(ManagerRegistry $doctrine, $id): Response
    {
        $vehicule = $doctrine->getRepository(Vehicle::class)->find($id);
        if (!$vehicule) {
            throw $this->createNotFoundException('Vehicle not found');
        }
        return $this->render('application/details.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }
}
