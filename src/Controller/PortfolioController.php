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
    public function index()
    {
        return $this->render('portfolio/index.html.twig', [
            'controller_name' => 'PortfolioController',
        ]);
    }
    /**
     * @Route("/dashbord", name="portfolio_dashbord")
     */
    public function dashbord(WorkRepository $repo)
    {
        $works = $repo->findAll();
            
        return $this->render('portfolio/dashbord.html.twig', [
            'works' => $works
        ]);
    }
}