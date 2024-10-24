<?php

namespace App\Controller;

use App\Dtos\ClientDto;
use App\Entity\Client;
use App\Entity\User;
use App\Form\ClientFormType;
use App\Form\DetteFilterType;
use App\Form\SearchClientFormType;
use App\Form\UserFormType;
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
        // $user = new User();
        $page = $request->query->getInt('page',1);
        $limit = 5;
        $clients = $this->clientRepository->paginateClients(   $page, $limit);
        $clientDto = new ClientDto();
      

        // Creation des formulaires : client-User-SearchClient

        $form = $this->createForm(ClientFormType::class, $client);

        // $formUser = $this->createForm(UserFormType::class, $user);

        $formSearch = $this->createForm(SearchClientFormType::class, $clientDto);

        $formSearch->handleRequest($request);
        
        if ($formSearch->isSubmitted() && $formSearch->isValid()) { 
            // $formSearch->get('telephone')->getData()
            $clients = $this->clientRepository->findByClient($clientDto, $page, $limit);

        } 
        $count = $clients->count();
        $maxPage = ceil( $count / $limit);
        return $this->render('client/index.html.twig', [
            'form' => $form->createView(),
            'formSearch' => $formSearch->createView(),
            'clients' => $clients,
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
    #[Route('client/dettes/{idClient}', name: 'dettesbyClient')]
    public function getDettesByClient(int $idClient , ClientRepository $clientRepository ): Response
    {
        $form = $this->createForm(DetteFilterType::class);
        $client = $clientRepository->find($idClient);
        return $this->render('client/dettes.html.twig', [
            'controller_name' => 'DetteController',
            'client'=> $client,
            'form'=> $form->createView(),
        ]);
    }
    
    
}
