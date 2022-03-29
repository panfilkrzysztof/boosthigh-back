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
     * @Route("/devices/vehicle_{id}", name="devices_by_vehicle_show")
     */
    public function showByVehicle(ManagerRegistry $doctrine, int $id): Response
    {
        $devices = $doctrine->getRepository(Devices::class)->findBy(array('vehicle_id' => $id));
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
}
