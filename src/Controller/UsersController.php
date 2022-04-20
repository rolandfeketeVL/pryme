<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/updateClient/{id}', name: 'updateClient', methods: ['POST', 'GET', 'HEAD'])]
    public function updateClient(Request $request, $id): Response
    {
        $UserRepository = $this->em->getRepository(Users::class);
        $client = $UserRepository->find($id);

        if($request->getContent())
        {
            $client->setFirstName($request->request->get('firstname'));
            $client->setLastName($request->request->get('lastname'));
            $client->setEmail($request->request->get('email'));
            $client->setPhone($request->request->get('phone'));
            $client->setStreet($request->request->get('street'));
            $client->setCity($request->request->get('city'));
            $client->setZip($request->request->get('zip'));
            $client->setState($request->request->get('state'));
            $client->setCountry($request->request->get('country'));

            $this->em->flush();
            return new JsonResponse('OK', JsonResponse::HTTP_OK);
        }

        return new JsonResponse($client, JsonResponse::HTTP_OK);
    }

}
