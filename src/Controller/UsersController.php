<?php

namespace App\Controller;

use App\Repository\MembershipRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use DateTime;

class UsersController extends AbstractController
{
    private EntityManagerInterface $em;
    private MembershipRepository $membershipRepository;
    private UserRepository $userRepository;
    private UserService $userService;

    public function __construct(EntityManagerInterface $em, UserRepository $userRepository, MembershipRepository $membershipRepository, UserService $userService)
    {
        $this->em = $em;
        $this->membershipRepository = $membershipRepository;
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    #[Route('/users', name: 'app_users')]
    public function index(): Response
    {
        $clients = $this->userRepository->findByRole("client");
        $memberships = $this->membershipRepository->findAll();

        $data = [
            "clients" => $clients,
            "memberships" => $memberships
        ];

        return $this->render('users/clients.html.twig', $data);
    }

    #[Route('/updateClient/{id}', name: 'updateClient', methods: ['POST', 'GET', 'HEAD'])]
    public function updateClient(Request $request, $id): Response
    {
        $client = $this->userRepository->find($id);
        $clientPrepared = $this->userService->prepareUser($client);

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

            if($this->getUser()->isAdmin()){
                $client->setMembership($this->membershipRepository->find($request->request->get('membership')));
                $client->setCreditsRemaining($request->request->get('credits'));
                $client->setMembershipExpiryDate(DateTime::createFromFormat('Y-m-d', $request->request->get('membership_expiration')));
            }

            $this->em->flush();
            return new JsonResponse('OK', JsonResponse::HTTP_OK);
        }

        return new JsonResponse($clientPrepared, JsonResponse::HTTP_OK);
    }

    #[Route('/profile', name: 'app_users_profile')]
    public function profile(): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        $userAppointments = $user->getAppointments();

        if($user->getmembershipExpiryDate()){
            $membershipExpiry = $user->getmembershipExpiryDate();
            $now = date_create_from_format('Y-m-d', date('Y-m-d'));
            $diff = date_diff($now, $membershipExpiry);
            $interval = $diff->format("%a");
        }else{
            $interval = 0;
        }


//        $clients = $this->userRepository->findByRole("client");
//        $memberships = $this->membershipRepository->findAll();

        $data = [
            "user" => $user,
            "daysLeft" => $interval,
            "userAppointments" => $userAppointments
        ];

        return $this->render('users/profile.html.twig', $data);
    }

}
