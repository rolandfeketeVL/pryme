<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Repository\MembershipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MembershipController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/membership', name: 'app_membership')]
    public function index(): Response
    {
        $repository = $this->em->getRepository(Membership::class);
        $memberships = $repository->count([]);

        dd($memberships);

        return $this->render('index.html.twig');
    }
}
