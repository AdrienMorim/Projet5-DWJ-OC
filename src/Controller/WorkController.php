<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WorkController extends AbstractController
{
    /**
     * @Route("/work/list", name="work_list")
     */
    public function listWork()
    {
        return $this->render('work/list.html.twig', [
            'controller_name' => 'WorkController',
        ]);
    }
    /**
     * @Route("/work/12", name="work_show")
     */
    public function showWork()
    {
        return $this->render('work/show.html.twig');
    }
}
