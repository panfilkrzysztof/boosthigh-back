<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Components;
use Doctrine\Persistence\ManagerRegistry;

class ComponentsController extends AbstractController
{
    /**
     * @Route("/components", name="components_list")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $components = $doctrine->getRepository(components::class)->findAll();
        if(count($components)>0){
            return $this->json(
            $components
        );
        } else {
            return $this->json([
            'error' => 'no data'
        ]);
        }
        
    }

    /**
     * @Route("/components/get_{id}", name="components_show")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $components = $doctrine->getRepository(components::class)->find($id);
        if(count($components)>0){
            return $this->json(
            $components
        );
        } else {
            return $this->json([
            'error' => 'no data'
        ]);
        }
    }

    /**
     * @Route("/components/device_{id}", name="components_by_device_show")
     */
    public function showByDevice(ManagerRegistry $doctrine, int $id): Response
    {
        $components = $doctrine->getRepository(components::class)->findBy(array('device_id' => $id));
        if(count($components)>0){
            return $this->json(
            $components
        );
        } else {
            return $this->json([
            'error' => 'no data'
        ]);
        }
    }

    /**
     * @Route("/components/edit_{id}", name="components_edit")
     */
    public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $request = Request::createFromGlobals();
        $components = $doctrine->getRepository(components::class)->find($id);
        if (!$components) {
            throw $this->createNotFoundException(
                'No components found for id '.$id
            );
        } else {
            $components->setName($request->query->get('name'))->setType($request->query->get('type'))->setDeviceId($request->query->get('device_id'));
            return new Response('components: '.$components->getName(). ' updated');
        }
    }

    /**
     * @Route("/components/add", name="components_add")
     */
    public function add(): Response
    {
        $request = Request::createFromGlobals();
        $components = new components();
        $components->setName($request->query->get('name'))->setType($request->query->get('type'))->setDeviceId($request->query->get('device_id'));
        return $this->json([
            'id' => $components->getId(),
            'device_id' => $components->getDeviceId(),
            'name' => $components->getName(),
            'type' => $components->getType()
        ]);
    }
}
