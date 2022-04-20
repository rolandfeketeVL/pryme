<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Repository\MembershipRepository;
use Doctrine\ORM\EntityManagerInterface;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\MembershipService;

class MembershipController extends AbstractController
{
    private EntityManagerInterface $em;
    private MembershipRepository $MembershipRepository;
    private MembershipService $membershipService;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->MembershipRepository = $this->em->getRepository(Membership::class);
        $this->membershipService = new MembershipService();
    }

    #[Route('/membership', name: 'membership')]
    public function index(): Response
    {

        $memberships = $this->MembershipRepository->findAll();

        $data = [
            'memberships' => $memberships
        ];
        return $this->render('membership/membership.html.twig', $data);
    }

    #[Route('/updateMembership/{id}', name: 'updateMembership', methods: ['POST', 'GET', 'HEAD'])]
    public function updateMembership(Request $request, $id): Response
    {
        $membership = $this->MembershipRepository->find($id);
        $membership_prepared = $this->membershipService->prepareMembership($membership);

        if($request->getContent())
    {
            $membership->setName($request->request->get('name'));
            $membership->setCredits($request->request->get('credits'));
            $membership->setValability($request->request->get('valability'));
            $membership->setPrice($request->request->get('price'));
            $membership->setPersonsNo($request->request->get('personsNo'));
            $membership->setMinutes($request->request->get('minutes'));

            $this->em->flush();
            return new JsonResponse('OK', JsonResponse::HTTP_OK);
        }

        return new JsonResponse($membership_prepared, JsonResponse::HTTP_OK);
    }

    #[Route('/createMembership/', name: 'createMembership', methods: ['POST', 'GET', 'HEAD'])]
    public function createMembership(Request $request): Response
    {
        $membership = new Membership();

        if($request->getContent())
        {
            $membership->setName($request->request->get('name'));
            $membership->setCredits($request->request->get('credits'));
            $membership->setValability($request->request->get('valability'));
            $membership->setPrice($request->request->get('price'));
            $membership->setPersonsNo($request->request->get('personsNo'));
            $membership->setMinutes($request->request->get('minutes'));

            $this->em->persist($membership);
            $this->em->flush();
            return new JsonResponse('OK', JsonResponse::HTTP_OK);
        }

        return new JsonResponse('NOT OK', JsonResponse::HTTP_OK);
    }
}
