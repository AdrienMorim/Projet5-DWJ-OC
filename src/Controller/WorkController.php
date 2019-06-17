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
     * @Route("/admin/work/list", name="work_list")
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
     * @Route("/admin/work/new", name="work_create", methods="GET|POST")
     * @Route("/admin/work/{id}/edit", name="work_edit", methods="GET|POST")
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

        $imageSave = $work->getImage(); // on récupère l'ancienne image sauvegarder

        $form = $this->createForm(WorkType::class, $work);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 

            // Ajouter une date de création uniquement si Work n'existe pas
            if (!$work->getId()) {
                $work->setCreatedAt(new \Datetime());
            }

            $work = $form->getData();

            $image = $work->getImage();

            if (isset($image)) {
                
                $file = $image->getFile();

                // Supprimer une image
                if (isset($imageSave) && !empty($file)){ // si une $imageSave existe et que $file n'est pas vide

                    $oldName = $imageSave->getName(); // on récupère le nom de l'ancienne image sauvegarder
                    $oldFile = $this->getParameter('images_directory'). '/' . $oldName; // on récupère le répertoire courant.
                    unlink($oldFile); // on efface le fichier
                }

                $name = md5(uniqid()).'.'.$file->guessExtension();
                $image->setName($name);
                
                $file->move(
                    $this->getParameter('images_directory'),
                    $name);
            }
            
            $manager->persist($work);
            $manager->flush();
            $this->addFlash('success', 'Le projet a bien été enregistré');

            return $this->redirectToRoute('work_show', ['id' => $work->getId()]);
        }
        return $this->render('work/create.html.twig', [
            'formWork' => $form->createView(),
            'editMode' => $work->getId() !== null,
            'work' => $work, // recupération de l'image dans la vue: {{ work.image.name }}
            'image' => $imageSave // recupération de l'image dans la vue: {{ image.name }}
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

            $imageName = $work->getImage()->getName();
            $file = $this->getParameter('images_directory'). '/' . $imageName;
            unlink($file);
            $manager->remove($work);
            $manager->flush();
            $this->addFlash('success', 'Le projet à bien été supprimé');
        }
        return $this->redirectToRoute('work_list');
    }
}
