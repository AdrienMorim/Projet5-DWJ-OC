<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Work;
use App\Repository\WorkRepository;

class WorkController extends AbstractController
{
    /**
     * @Route("/work/list", name="work_list")
     */
    public function listWork(WorkRepository $repo)
    {
        $works = $repo->findAll();

        return $this->render('work/list.html.twig', [
            'controller_name' => 'WorkController',
            'works' => $works
        ]);
    }
    /**
     * @Route("/work/{id}", name="work_show")
     */
    public function showWork(Work $work)
    {
        return $this->render('work/show.html.twig', [
            'work' => $work
        ]);
    }
}
