<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Entity\Users;
use App\Form\EditClientFormType;
use Doctrine\ORM\EntityManagerInterface;
//use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/users', name: 'app_users')]
    public function index(): Response
    {
        $UserRepository = $this->em->getRepository(Users::class);
        $MembershipRepository = $this->em->getRepository(Membership::class);
        $clients = $UserRepository->findByRole("client");

        foreach ($clients as $client)
        {

            $client->setMembership($MembershipRepository->findOneById($client->getMembership()->getId()));
        }

        $data = [
            "clients" => $clients
        ];

        return $this->render('users/clients.html.twig', $data);
    }

    #[Route('/updateClient/{id}', methods: ['POST'])]
    public function updateClient($id, Request $request): Response
    {
        $UserRepository = $this->em->getRepository(Users::class);
        $client = $UserRepository->find($id);
        $form = $this->createForm(EditClientFormType::class, $client);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            dd('OK');
        }

        return new JsonResponse($client, JsonResponse::HTTP_OK);
    }
}
