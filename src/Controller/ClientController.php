<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientFormType;
use App\Form\SearchClientFormType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{

    private $clientRepository;
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }
    #[Route('/client', name: 'app_client')]
    public function index(Request $request): Response
    {
        $client = new Client();
        $page = $request->query->getInt('page',1);
        $limit = 5;
        $clients = $this->clientRepository->paginateClients(   $page, $limit);
        $count = $this->clientRepository->countClients();
        $maxPage = ceil( $count / $limit);

        $data = array_map(function($client) {
            return [
                'id' => $client->getId(),
                'surname' => $client->getSurname(),
                'telephone' => $client->getTelephone(),
                'adresse' => $client->getAdresse(),
            ];
        }, iterator_to_array($clients->getIterator()));
        
        $form = $this->createForm(ClientFormType::class, $client);
        $formSearch = $this->createForm(SearchClientFormType::class);
        $formSearch->handleRequest($request);


        

        if ($formSearch->isSubmitted() && $formSearch->isValid()) { 
            $data = $this->clientRepository->findBy(['telephone' => $formSearch->get('telephone')->getData()]);

        } 
        return $this->render('client/index.html.twig', [
            'form' => $form->createView(),
            'formSearch' => $formSearch->createView(),
            'clients' => $data,
            'maxPage' => $maxPage,
            'page' => $page,

        ]);
    }

    #[Route('/client/new', name: 'client_new')]
    public function new(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientFormType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($client);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_client');
        }

        return $this->render('client/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
}
