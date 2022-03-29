<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Status;
use Doctrine\Persistence\ManagerRegistry;

class StatusController extends AbstractController
{
    /**
     * @Route("/status", name="status_list")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $status = $doctrine->getRepository(status::class)->findAll();
        
        if(count($status)>0){
            return $this->json(
            $status
        );
        } else {
            return $this->json([
            'error' => 'no data'
        ]);
        }
        
    }

    /**
     * @Route("/status/get_{id}", name="status_show")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $status = $doctrine->getRepository(status::class)->find($id);

        if (!$status) {
            throw $this->createNotFoundException(
                'No status found for id '.$id
            );
        }

        return new Response('Check out this great status: '.$status->getdescription());
    }
    /**
     * @Route("/status/edit_{id}", name="status_edit")
     */
    public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $request = Request::createFromGlobals();
        $status = $doctrine->getRepository(status::class)->find($id);

        if (!$status) {
            throw $this->createNotFoundException(
                'No status found for id '.$id
            );
        } else {
            $status->setdescription($request->query->get('description'))->setType($request->query->get('type'))->setComponentId($request->query->get('component_id'));
            return new Response('status: '.$status->getdescription(). ' updated');
        }

        
    }

    /**
     * @Route("/status/add", name="status_add")
     */
    public function add(): Response
    {
        $request = Request::createFromGlobals();
        $status = new status();
        $status->setdescription($request->query->get('description'))->setType($request->query->get('type'))->setComponentId($request->query->get('component_id'));
        return $this->json([
            'id' => $status->getId(),
            'component_id' => $status->getComponentId(),
            'description' => $status->getDescription(),
            'type' => $status->getType()
        ]);
    }
    /**
     * @Route("/status/generate", name="status_generate")
     */
    public function generate(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $status = new status();
        $status->setdescription('Brak zasilania')->setType('error')->setComponentId(1);

        $entityManager->persist($status);
        $entityManager->flush();

        return $this->json([
            'id' => $status->getId(),
            'component_id' => $status->getComponentId(),
            'description' => $status->getDescription(),
            'type' => $status->getType()
        ]);
    }
    /**
     * @Route("/status/generate2", name="status_generate2")
     */
    public function generate2(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $status = new status();
        $status->setdescription('Zacięcie papieru')->setType('warning')->setComponentId(21);

        $entityManager->persist($status);
        $entityManager->flush();

        return $this->json([
            'id' => $status->getId(),
            'component_id' => $status->getComponentId(),
            'description' => $status->getDescription(),
            'type' => $status->getType()
        ]);
    }
}
