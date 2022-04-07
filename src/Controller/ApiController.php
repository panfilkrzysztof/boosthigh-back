<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Vehicles;
use App\Entity\Devices;
use App\Entity\Components;
use App\Entity\Status;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="app_api")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiController.php',
        ]);
    }

    /**
     * @Route("/get_all_data", name="api_all")
     */
    public function getAllData(ManagerRegistry $doctrine): Response
    {
        $json;
        // 1st level get all Vehicle
        $vehicles = $doctrine->getRepository(Vehicles::class)->findAll();
        if(count($vehicles)>0){
            foreach($vehicles as $vehicle){
                // 2nd level get all device for single vehicle
                $devices = $doctrine->getRepository(Devices::class)->findBy(array('vehicle_id' => $vehicle->getId()));
                if(count($devices)>0){
                    $deviceArray=[];
                    foreach($devices as $device){
                        // 3th level get all component for single device
                        $components = $doctrine->getRepository(Components::class)->findBy(array('device_id' => $device->getId()));
                        if(count($components)>0){
                            $componentArray=[];
                            foreach($components as $component){
                                //4ty level get all status for single component
                                $status = $doctrine->getRepository(Status::class)->findBy(array('component_id' => $component->getId()));
                                if(count($status)>0){
                                    $statusArray=[];
                                    foreach($status as $stat){
                                        $statusArray[] = ['id'=> $stat->getId(), 
                                                    'type' => $stat->getType(), 
                                                    'description' => $stat->getDescription()];
                                    }
                                    $componentArray[] = ['id'=> $component->getId(), 
                                                    'type' => $component->getType(), 
                                                    'name' => $component->getName(),
                                                    'status' => $statusArray];
                                } else {
                                    $componentArray[] = ['id'=> $component->getId(), 
                                                    'type' => $component->getType(), 
                                                    'name' => $component->getName()];
                                }  
                            }
                            $deviceArray[] = ['id'=> $device->getId(), 
                                            'type' => $device->getType(), 
                                            'name' => $device->getName(),
                                            'component' => $componentArray];
                        } else {
                            $deviceArray[] = ['id'=> $device->getId(), 
                                            'type' => $device->getType(), 
                                            'name' => $device->getName()];
                        }
                    }
                    $json[]=['id'=> $vehicle->getId(), 
                            'type' => $vehicle->getType(), 
                            'name' => $vehicle->getName(),
                            'device' => $deviceArray];
                } else {
                    $json[]=['id'=> $vehicle->getId(), 
                            'type' => $vehicle->getType(), 
                            'name' => $vehicle->getName()];
                }
            }
            return $this->json($json);
        } else {
            return $this->json([
            'error' => 'no data'
        ]);
        }
    }
}
