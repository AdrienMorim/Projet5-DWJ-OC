<?php

namespace App\Controller;

use App\Entity\Work;
use App\Entity\Image;
use App\Form\WorkType;
use App\Repository\WorkRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WorkController extends AbstractController
{
    /**
     * @Route("/work/list", name="work_list")
     *
     * @param WorkRepository $repo
     * @return void
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
     * @Route("/work/new", name="work_create", methods="GET|POST")
     * @Route("/work/{id}/edit", name="work_edit", methods="GET|POST")
     *
     * @param Work $work
     * @param Request $request
     * @param ObjectManager $manager
     * @return void
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

            $work = $form->getData();
            $image = $work->getImage();
            $file = $image->getFile();
            $name = md5(uniqid()).'.'.$file->guessExtension();
            $image->setName($name); 
            $file->move(
                $this->getParameter('images_directory'),
                $name);
            
            $manager->persist($work);
            $manager->flush();
            $this->addFlash('success', 'Le projet a bien été enregistré');

            return $this->redirectToRoute('work_show', ['id' => $work->getId()]);
        }
        return $this->render('work/create.html.twig', [
            'formWork' => $form->createView(),
            'editMode' => $work->getId() !== null
        ]);
    }

    /**
     * @Route("/work/{id}", name="work_show")
     * 
     * @param Work $work
     * @return void
     */
    public function showWork(Work $work)
    {
        return $this->render('work/show.html.twig', [
            'work' => $work
        ]);
    }

    /**
     * 
     * @Route("/work/{id}/remove", name="work_remove", methods="REMOVE")
     *
     * @param Work $work
     * @param ObjectManager $manager
     * @param Request $request
     * @return void
     */
    public function removeWork(Work $work, ObjectManager $manager, Request $request)
    {
        $submittedToken = $request->request->get('_token');
        $workId = $work->getId();

        if($this->isCsrfTokenValid('remove-work' . $workId, $submittedToken)) {

            $manager->remove($work);
            $manager->flush();
            $this->addFlash('success', 'Le projet à bien été supprimé');
        }
        return $this->redirectToRoute('work_list');
    }
}
