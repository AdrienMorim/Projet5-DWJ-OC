<?php

namespace App\Controller;

use App\Entity\Work;
use App\Form\WorkType;
use App\Entity\Category;
use App\Repository\WorkRepository;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/work/new", name="work_create")
     * @Route("/work/{id}/edit", name="work_edit")
     */
    public function formWork(Work $work = null, Request $request, ObjectManager $manager)
    {
        if (!$work) {
            $work = new Work();
        }

        $form = $this->createForm(WorkType::class, $work);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$work->getId()) {
                $work->setCreatedAt(new \Datetime());
            }

            $manager->persist($work);
            $manager->flush();

            return $this->redirectToRoute('work_show', ['id' => $work->getId()]);
        }

        return $this->render('work/create.html.twig', [
            'formWork' => $form->createView(),
            'editMode' => $work->getId() !== null
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

    /**
     * Supprimer un Work (voir ci supp aussi lien entre work<->category)
     * 
     * @Route("/work/{id}/remove", name="work_remove")
     *
     * @param Work $work
     * @param ObjectManager $manager
     * @return void
     */
    public function removeWork(Work $work, ObjectManager $manager)
    {
        if($work) {
            $manager->remove($work);
            $manager->flush();

            return $this->redirectToRoute('work_list');
        }
        return $this->render('work/list.html.twig');
    }
}
