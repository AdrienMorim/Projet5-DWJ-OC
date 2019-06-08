<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\WorkRepository;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/", name="portfolio")
     */
    public function index(WorkRepository $repo)
    {
        $works = $repo->findAll();

        return $this->render('portfolio/index.html.twig', [
            'controller_name' => 'PortfolioController',
            'works' => $works
        ]);
    }
    /**
     * @Route("/dashboard", name="portfolio_dashboard")
     */
    public function dashboard(WorkRepository $repo)
    {
        $works = $repo->findAll();
            
        return $this->render('portfolio/dashboard.html.twig', [
            'works' => $works
        ]);
    }
}