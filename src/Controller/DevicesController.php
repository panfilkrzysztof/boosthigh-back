<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Devices;
use Doctrine\Persistence\ManagerRegistry;

class DevicesController extends AbstractController
{
    /**
     * @Route("/devices", name="devices_list")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $devices = $doctrine->getRepository(Devices::class)->findAll();
        
        if(count($devices)>0){
            return $this->json(
            $devices
        );
        } else {
            return $this->json([
            'error' => 'no data'
        ]);
        }
        
    }

    /**
     * @Route("/devices/get_{id}", name="devices_show")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $devices = $doctrine->getRepository(Devices::class)->find($id);

        if (!$devices) {
            throw $this->createNotFoundException(
                'No devices found for id '.$id
            );
        }

        return new Response('Check out this great devices: '.$devices->getName());
    }
    /**
     * @Route("/devices/edit_{id}", name="devices_edit")
     */
    public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $request = Request::createFromGlobals();
        $devices = $doctrine->getRepository(Devices::class)->find($id);

        if (!$devices) {
            throw $this->createNotFoundException(
                'No devices found for id '.$id
            );
        } else {
            $devices->setName($request->query->get('name'))->setType($request->query->get('type'))->setVehicleId($request->query->get('vehicle_id'));
            return new Response('devices: '.$devices->getName(). ' updated');
        }

        
    }

    /**
     * @Route("/devices/add", name="devices_add")
     */
    public function add(): Response
    {
        $request = Request::createFromGlobals();
        $devices = new Devices();
        $devices->setName($request->query->get('name'))->setType($request->query->get('type'))->setVehicleId($request->query->get('vehicle_id'));
        return $this->json([
            'id' => $devices->getId(),
            'vehicle_id' => $devices->getVehicleId(),
            'name' => $devices->getName(),
            'type' => $devices->getType()
        ]);
    }
    /**
     * @Route("/devices/generate", name="devices_generate")
     */
    public function generate(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $devices = new Devices();
        $devices->setName('Biletomat nr 1')->setType('ticket_machine')->setVehicleId(1);

        $entityManager->persist($devices);
        $entityManager->flush();

        return $this->json([
            'id' => $devices->getId(),
            'vehicle_id' => $devices->getVehicleId(),
            'name' => $devices->getName(),
            'type' => $devices->getType()
        ]);
    }
    /**
     * @Route("/devices/generate2", name="devices_generate2")
     */
    public function generate2(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $devices = new Devices();
        $devices->setName('Biletomat nr 2')->setType('ticket_machine')->setVehicleId(1);

        $entityManager->persist($devices);
        $entityManager->flush();

        return $this->json([
            'id' => $devices->getId(),
            'vehicle_id' => $devices->getVehicleId(),
            'name' => $devices->getName(),
            'type' => $devices->getType()
        ]);
    }
}
