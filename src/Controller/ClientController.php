<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    // #[Route('/client', name: 'app_client')]
    // public function index(): Response
    // {
    //     return $this->render('client/index.html.twig', [
    //         'controller_name' => 'ClientController',
    //     ]);
    // }

    #[Route('/client', name: 'client_new')]
    public function new(Request $request): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientFormType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_success');
        }

        return $this->render('client/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
