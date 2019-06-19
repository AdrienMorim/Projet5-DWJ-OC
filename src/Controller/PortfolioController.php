<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\WorkRepository;
use App\Repository\CategoryRepository;
use App\Entity\Category;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/", name="portfolio")
     */
    public function index(WorkRepository $repoWork, CategoryRepository $repoCategory)
    {
        $works = $repoWork->findAll();
        $categories = $repoCategory->findAll();
        $firstCategory = $repoCategory->find(1);

        return $this->render('portfolio/index.html.twig', [
            'controller_name' => 'PortfolioController',
            'works' => $works,
            'categories' => $categories,
            'firstCategory' => $firstCategory
        ]);
    }
    /**
     * @Route("/admin/dashboard", name="portfolio_dashboard")
     */
    public function dashboard(WorkRepository $repoWork, CategoryRepository $repoCategory)
    {
        $works = $repoWork->findAll();
        $categories = $repoCategory->findAll();
            
        return $this->render('portfolio/dashboard.html.twig', [
            'works' => $works,
            'categories' => $categories
        ]);
    }
}