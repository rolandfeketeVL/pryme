<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }else{
            if(!$this->getUser()->isAdmin()){
                return $this->redirectToRoute('app_users_profile');
            }
        }



        $data = [];
        return $this->render('dashboard/dashboard.html.twig', $data);
    }
}
