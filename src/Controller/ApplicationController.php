<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\AddVehicleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;

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

    #[Route(path: '/vehicle', name: 'vehicle_list')]
    public function vehicleList(Request $request, ManagerRegistry $doctrine): Response
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(AddVehicleType::class, $vehicle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($vehicle);
            $entityManager->flush();
            $this->addFlash('success', 'Vehicle added successfully');
            return $this->redirectToRoute('app_vehicles');
        }
        $vehicles = $doctrine->getRepository(Vehicle::class)->findAll();
        return $this->render('vehicle/index.html.twig', [
            'form' => $form->createView(),
            'vehicles' => $vehicles,
        ]);
    }

    #[Route(path: '/vehicle/add', name: 'vehicle_add')]
    public function addVehicle(Request $request, ManagerRegistry $doctrine): Response
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(AddVehicleType::class, $vehicle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($vehicle);
            $entityManager->flush();
            $this->addFlash('success', 'Vehicle added successfully');
            return $this->redirectToRoute('app_vehicles');
        }
        return $this->render('vehicle/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/vehicle/edit/{id}', name: 'vehicle_edit')]
    public function editVehicle(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $vehicle = $doctrine->getRepository(Vehicle::class)->find($id);
        if (!$vehicle) {
            throw $this->createNotFoundException('Vehicle not found');
        }
        $form = $this->createForm(AddVehicleType::class, $vehicle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();
            $this->addFlash('success', 'Vehicle updated successfully');
            return $this->redirectToRoute('app_vehicles');
        }
        return $this->render('vehicle/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/vehicle/delete/{id}', name: 'vehicle_delete')]
    public function deleteVehicle(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $vehicle = $doctrine->getRepository(Vehicle::class)->find($id);
        if ($vehicle) {
            $entityManager->remove($vehicle);
            $entityManager->flush();
            $this->addFlash('success', 'Vehicle deleted successfully');
        } else {
            $this->addFlash('error', 'Vehicle not found');
        }
        return $this->redirectToRoute('app_vehicles');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $entityManager->persist($form->getData());
                $entityManager->flush();
                return $this->redirectToRoute('app_contact');
            }
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
