<?php

namespace App\Controller;

use App\Entity\MembershipGroup;
use App\Repository\MembershipGroupRepository;
use App\Service\MembershipGroupService;
use App\Service\MembershipService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class MembershipGroupController extends AbstractController
{
    private EntityManagerInterface $em;
    private MembershipGroupRepository $membershipGroupRepository;
    private MembershipGroupService $membershipGroupService;

    public function __construct(EntityManagerInterface $em, MembershipGroupRepository $membershipGroupRepository, MembershipGroupService $membershipGroupService)
    {
        $this->em = $em;
        $this->membershipGroupRepository = $membershipGroupRepository;
        $this->membershipGroupService = $membershipGroupService;
    }

    #[Route('/membershipGroups', name: 'membership_groups')]
    public function index(): Response
    {
        $membershipGroups = $this->membershipGroupRepository->findAll();

        $data = [
            'membershipGroups' => $membershipGroups
        ];
        return $this->render('membership_group/membershipGroup.twig', $data);
    }

    #[Route('/updateMembershipGroup/{id}', name: 'updateMembershipGroup', methods: ['POST', 'GET', 'HEAD'])]
    public function updateMembershipGroup(Request $request, $id): Response
    {

        $membershipGroup = $this->membershipGroupRepository->find($id);
        $membershipGroup_prepared = $this->membershipGroupService->prepareMembershipGroup($membershipGroup);

        if($request->getContent())
        {
            $membershipGroup->setName($request->request->get('name'));
            $membershipGroup->setBenefitLink($request->request->get('benefitLink'));

            $this->em->flush();
            return new JsonResponse('OK', JsonResponse::HTTP_OK);
        }

        return new JsonResponse($membershipGroup_prepared, JsonResponse::HTTP_OK);
    }

    #[Route('/createMembershipGroup/', name: 'createMembershipGroup', methods: ['POST', 'GET', 'HEAD'])]
    public function createMembershipGroup(Request $request): Response
    {
        $membershipGroup = new MembershipGroup();

        if($request->getContent())
        {
            $membershipGroup->setName($request->request->get('name'));
            $membershipGroup->setBenefitLink($request->request->get('benefitLink'));

            $this->em->persist($membershipGroup);
            $this->em->flush();
            return new JsonResponse('OK', JsonResponse::HTTP_OK);
        }

        return new JsonResponse('NOT OK', JsonResponse::HTTP_OK);
    }

    #[Route('/deleteMembershipGroup/{id}', name: 'deleteMembershipGroup', methods: ['GET', 'DELETE'])]
    public function deleteMembershipGroup(Request $request, $id): Response
    {
        $membershipGroup = $this->membershipGroupRepository->find($id);
        $this->em->remove($membershipGroup);
        $this->em->flush();

        return new JsonResponse('OK', JsonResponse::HTTP_OK);
    }
}
