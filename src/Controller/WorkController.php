<?php

namespace App\Controller;

use App\Entity\Work;
use App\Form\WorkType;
use App\Repository\WorkRepository;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

class WorkController extends AbstractController
{
    /**
     * @Route("/admin/work/list", name="work_list")
     *
     * @param WorkRepository $repo
     * @return void
     */
    public function listWork(WorkRepository $repo, Request $request, ObjectManager $manager, PaginatorInterface $paginator)
    {
        //$works = $repo->findAll();
        $dql = "SELECT w FROM App:Work w";
        $query = $manager->createQuery($dql);

        $works = $paginator->paginate(
            $query, /* Use de query */
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit', 3) /*limit per page*/
        );

        return $this->render('work/list.html.twig', [
            'controller_name' => 'WorkController',
            'works' => $works,
        ]);
    }

    /**
     * @Route("/admin/work/new", name="work_create", methods="GET|POST")
     * @Route("/admin/work/{id}/edit", name="work_edit", methods="GET|POST")
     *
     * @param Work $work
     * @param Request $request
     * @param ObjectManager $manager
     */
    public function formWork(Work $work = null, Request $request, ObjectManager $manager)
    {
        if (!$work) {
            $work = new Work();
        }

        $form = $this->createForm(WorkType::class, $work);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 

            // Ajouter une date de création uniquement si Work n'existe pas
            if (!$work->getId()) {
                $work->setCreatedAt(new \Datetime());
            }

            $work->setUpdatedAt(new \Datetime());
            
            $manager->persist($work);
            $manager->flush();
            $this->addFlash('success', 'Le projet a bien été enregistré');

            return $this->redirectToRoute('work_show', ['id' => $work->getId()]);
        }
        return $this->render('work/create.html.twig', [
            'formWork' => $form->createView(),
            'editMode' => $work->getId() !== null,
            'work' => $work, // recupération de l'image dans la vue: {{ work.imageName }}
        ]);
    }

    /**
     * @Route("/admin/work/{id}", name="work_show")
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
     * @Route("/admin/work/{id}/remove", name="work_remove", methods="REMOVE")
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
