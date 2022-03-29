<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Vehicles;
use Doctrine\Persistence\ManagerRegistry;

class VehiclesController extends AbstractController
{
    /**
     * @Route("/vehicles", name="vehicles_list")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $Vehicles = $doctrine->getRepository(Vehicles::class)->findAll();
        
        if(count($Vehicles)>0){
            return $this->json(
            $Vehicles
        );
        } else {
            return $this->json([
            'error' => 'no data'
        ]);
        }
        
    }

    /**
     * @Route("/vehicles/get_{id}", name="vehicles_show")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $vehicles = $doctrine->getRepository(vehicles::class)->find($id);

        if (!$vehicles) {
            throw $this->createNotFoundException(
                'No vehicles found for id '.$id
            );
        }

        return new Response('Check out this great vehicles: '.$vehicles->getName());
    }
    /**
     * @Route("/vehicles/edit_{id}", name="vehicles_edit")
     */
    public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $request = Request::createFromGlobals();
        $vehicles = $doctrine->getRepository(vehicles::class)->find($id);

        if (!$vehicles) {
            throw $this->createNotFoundException(
                'No vehicles found for id '.$id
            );
        } else {
            $vehicles->setName($request->query->get('name'))->setType($request->query->get('type'));
            return new Response('Vehicles: '.$vehicles->getName(). ' updated');
        }

        
    }

    /**
     * @Route("/vehicles/add", name="vehicles_add")
     */
    public function add(): Response
    {
        $request = Request::createFromGlobals();
        $Vehicles = new Vehicles();
        $Vehicles->setName($request->query->get('name'))->setType($request->query->get('type'));
        return $this->json([
            'id' => $Vehicles->getId(),
            'name' => $Vehicles->getName(),
            'type' => $Vehicles->getType()
        ]);
    }
}
