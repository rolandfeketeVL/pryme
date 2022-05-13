<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Appointment;
use App\Repository\AppointmentRepository;
use App\Repository\EventRepository;
use App\Repository\MembershipGroupRepository;
use App\Repository\MembershipRepository;
use App\Repository\TrainerRepository;
use App\Repository\UserRepository;
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
    private EventRepository $eventRepository;
    private MembershipRepository $membershipRepository;
    private TrainerRepository $trainerRepository;
    private MembershipService $membershipService;
    private MembershipGroupRepository $membershipGroupRepository;
    private UserRepository $userRepository;
    private AppointmentRepository $appointmentRepository;

    public function __construct(EntityManagerInterface $em, MembershipRepository $membershipRepository, MembershipService $membershipService, TrainerRepository $trainerRepository, EventRepository $eventRepository, MembershipGroupRepository $membershipGroupRepository, UserRepository $userRepository, AppointmentRepository $appointmentRepository)
    {
        $this->em = $em;
        $this->membershipRepository = $membershipRepository;
        $this->membershipService = $membershipService;
        $this->trainerRepository = $trainerRepository;
        $this->eventRepository = $eventRepository;
        $this->membershipGroupRepository = $membershipGroupRepository;
        $this->userRepository = $userRepository;
        $this->appointmentRepository = $appointmentRepository;
    }

    #[Route('/calendar', name: 'calendar')]
    public function index(): Response
    {
        $memberships = $this->membershipRepository->findAll();
        $membershipsGroups = $this->membershipGroupRepository->findAll();
        $trainers = $this->trainerRepository->findAll();
        $events = $this->eventRepository->findAll();
        //dd($events);

        $data = [
            'memberships' => $memberships,
            'membershipsGroups' => $membershipsGroups,
            'trainers' => $trainers,
            'events' => $events
        ];

        return $this->render('calendar/calendar.html.twig', $data);
    }

    #[Route('/createEvent/', name: 'createEvent', methods: ['POST', 'GET', 'HEAD'])]
    public function createEvent(Request $request): Response
    {
        if($request->getContent())
        {
            $event = new Event();

            $startdate = DateTime::createFromFormat('Y-m-d H:i', $request->request->get('start-date'));
            $enddate = DateTime::createFromFormat('Y-m-d H:i', $request->request->get('end-date'));

            $event->setName($request->request->get('name'));
            $event->setLink($request->request->get('link'));
            if($request->request->get('trainer')){
                $event->setTrainer($this->trainerRepository->find($request->request->get('trainer')));
            }
            //$event->setMembership($this->membershipRepository->findOneBy(['name' => $request->request->get('name')]));
            $event->setMembershipsGroup($this->membershipGroupRepository->findOneBy(['name' => $request->request->get('name')]));
            $event->setStartdate($startdate);
            $event->setEnddate($enddate);

            $this->em->persist($event);
            $this->em->flush();

            // If the event is recursive, create the other events
            if($request->request->get('recursive') == 'on'){
                $recursiveEnd = DateTime::createFromFormat('Y-m-d H:i', $request->request->get('recursive-end-date'));

                date_add($startdate, date_interval_create_from_date_string('7 days'));
                date_add($enddate, date_interval_create_from_date_string('7 days'));

                $events = array();

                $i = 0;

                while($enddate <= $recursiveEnd){

                    $events[] = new Event();
                    $events[$i]->setName($request->request->get('name'));
                    $events[$i]->setLink($request->request->get('link'));
                    if($request->request->get('trainer')){
                        $events[$i]->setTrainer($this->trainerRepository->find($request->request->get('trainer')));
                    }
                    $events[$i]->setMembershipsGroup($this->membershipGroupRepository->findOneBy(['name' => $request->request->get('name')]));
                    $events[$i]->setStartdate($startdate);
                    $events[$i]->setEnddate(($enddate));

                    $this->em->persist($events[$i]);
                    $this->em->flush();

                    date_add($startdate, date_interval_create_from_date_string('7 days'));
                    date_add($enddate, date_interval_create_from_date_string('7 days'));

                    $i++;
                }
            }
            return new JsonResponse('OK', JsonResponse::HTTP_OK);
        }

        return new JsonResponse('NOT OK', JsonResponse::HTTP_OK);
    }

    #[Route('/updateEvent/{id}', name: 'updateEvent', methods: ['POST', 'GET', 'HEAD'])]
    public function updateEvent(Request $request, $id): Response
    {
        $event = $this->eventRepository->find($id);

        if($request->getContent())
        {
            $startdate = DateTime::createFromFormat('Y-m-d H:i', $request->request->get('start-date'));
            $enddate = DateTime::createFromFormat('Y-m-d H:i', $request->request->get('end-date'));

            $event->setName($request->request->get('name'));
            $event->setLink($request->request->get('link'));
            if($request->request->get('trainer')){
                $event->setTrainer($this->trainerRepository->find($request->request->get('trainer')));
            }
            $event->setMembershipsGroup($this->membershipGroupRepository->findOneBy(['name' => $request->request->get('name')]));
            $event->setStartdate($startdate);
            $event->setEnddate($enddate);

            $this->em->flush();
            return new JsonResponse('OK', JsonResponse::HTTP_OK);
        }

        return new JsonResponse('NOT OK', JsonResponse::HTTP_OK);
    }

    #[Route('/deleteEvent/{id}', name: 'deleteEvent', methods: ['GET', 'DELETE'])]
    public function deleteEvent(Request $request, $id): Response
    {
        $event = $this->eventRepository->find($id);
        $this->em->remove($event);
        $this->em->flush();

        return new JsonResponse('OK', JsonResponse::HTTP_OK);
    }

    #[Route('/appointmentsCalendar/{user_id}', name: 'appointmentsCalendar', methods: ['GET'])]
    public function appointmentsCalendar($user_id = 0): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        if($user_id == 0){
            $user_id = $this->getUser()->getId();
        }else{
            if(!$this->getUser()->isAdmin()){
                return $this->redirectToRoute('app_users_profile');
            }
        }
        $memberships = $this->membershipRepository->findAll();
        $client = $this->userRepository->find($user_id);

        $events = [];
        if($client->getMembership()){
            if($client->getMembership()->getMembershipGroup()){
                $events = $client->getMembership()->getMembershipGroup()->getEvents();
            }
        }

        $now = date_create_from_format('Y-m-d', date('Y-m-d'));
        foreach ($events as $key => $e){
            if(($now > $e->getStartdate()) || ($client->getMembershipExpiryDate() < $e->getStartdate()) || (count($e->getAppointments()) >= $client->getMembership()->getPersonsNo())){
                unset($events[$key]);
            }
        }

        $clientAppointments = $client->getAppointments();

        $appointedEvents = array();
        $appointedEventsIDS = array();
        foreach ($clientAppointments as $appointment){
            if($now < $appointment->getEvent()->getStartdate()){
                $appointedEvents[] = $appointment->getEvent();
                $appointedEventsIDS[] = $appointment->getEvent()->getId();
            }
        }

        $data = [
            'memberships' => $memberships,
            'events' => $events,
            'appointedEvents' => $appointedEvents,
            'appointedEventsIDS' => $appointedEventsIDS,
            'user_id' => $user_id
        ];

        return $this->render('calendar/appointmentsCalendar.html.twig', $data);
    }

    #[Route('/createAppointment/{event_id}/{user_id}', name: 'createAppointment', methods: ['GET', 'POST'])]
    public function createAppointment($event_id, $user_id): Response
    {
        $client = $this->userRepository->find($user_id);
        $event = $this->eventRepository->find($event_id);

        $event_appointments = $event->getAppointments();

        if(count($event_appointments) >= $client->getMembership()->getPersonsNo()){
            $this->addFlash(
                'error',
                'Too many persons registered to this event'
            );
            return $this->redirectToRoute('appointmentsCalendar');
        }

        if($client->getCreditsRemaining() <= 0) {
            $this->addFlash(
                'error',
                'You have no credits remaining!'
            );
            return $this->redirectToRoute('appointmentsCalendar');
        }else{
            $client->decreaseCredits();
        }

        $appointment = new Appointment();
        $appointment->setEvent($event);
        $appointment->setUser($client);
        $appointment->setGuestlist(false);

        $this->em->persist($appointment);
        $this->em->persist($client);
        $this->em->flush();

        return new JsonResponse('OK', JsonResponse::HTTP_OK);
    }

    #[Route('/deleteAppointment/{event_id}/{user_id}', name: 'deleteAppointment', methods: ['GET', 'DELETE'])]
    public function deleteAppointment($event_id, $user_id): Response
    {
        $criteria = [
            "event" => $event_id,
            "user"  => $user_id
        ];
        $appointment = $this->appointmentRepository->findOneBy($criteria);
        $client = $this->userRepository->find($user_id);
        $client->increaseCredits();

        $this->em->remove($appointment);
        $this->em->persist($client);

        $this->em->flush();

        return new JsonResponse('OK', JsonResponse::HTTP_OK);
    }
}
