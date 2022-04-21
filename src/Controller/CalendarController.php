<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Membership;
use App\Repository\MembershipRepository;
use App\Repository\TrainerRepository;
use App\Service\MembershipService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CalendarController extends AbstractController
{
    private EntityManagerInterface $em;
    private MembershipRepository $membershipRepository;
    private TrainerRepository $trainerRepository;
    private MembershipService $membershipService;

    public function __construct(EntityManagerInterface $em, MembershipRepository $membershipRepository, MembershipService $membershipService, TrainerRepository $trainerRepository)
    {
        $this->em = $em;
        $this->membershipRepository = $membershipRepository;
        $this->membershipService = $membershipService;
        $this->trainerRepository = $trainerRepository;
    }

    #[Route('/calendar', name: 'calendar')]
    public function index(): Response
    {
        $memberships = $this->membershipRepository->findAll();
        $trainers = $this->trainerRepository->findAll();
        //dd($memberships);

        $data = [
            'memberships' => $memberships,
            'trainers' => $trainers
        ];

        return $this->render('calendar/calendar.html.twig', $data);
    }

    #[Route('/createEvent/', name: 'createEvent', methods: ['POST', 'GET', 'HEAD'])]
    public function createEvent(Request $request): Response
    {
        $event = new Event();

        if($request->getContent())
        {
            $startdate = DateTime::createFromFormat('Y-m-d H:i', $request->request->get('start-date'));
            $enddate = DateTime::createFromFormat('Y-m-d H:i', $request->request->get('end-date'));

            $event->setName($request->request->get('name'));
            $event->setTrainer($this->trainerRepository->find($request->request->get('trainer')));
            $event->setMembership($this->membershipRepository->findOneBy(['name' => $request->request->get('name')]));
            $event->setStartdate($startdate);
            $event->setEnddate($enddate);

            $this->em->persist($event);
            $this->em->flush();
            return new JsonResponse('OK', JsonResponse::HTTP_OK);
        }

        return new JsonResponse('NOT OK', JsonResponse::HTTP_OK);
    }
}
