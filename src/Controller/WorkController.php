<?php

namespace App\Controller;

use App\Entity\Work;
use App\Form\WorkType;
use App\Entity\Category;
use App\Repository\WorkRepository;
use App\Repository\CategoryRepository;

use Knp\Component\Pager\PaginatorInterface;
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
     * @Route("/admin/work/{id}/edit", name="work_edit", methods="GET|POST", requirements={"id"="\d+"})
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
     * @Route("/admin/work/{id}", name="work_show" ,requirements={"id"="\d+"})
     * 
     * @param Work $work
     * @param Category $categories
     * @return void
     */
    public function showWork(Work $work, CategoryRepository $repoCategory)
    {
        return $this->render('work/show.html.twig', [
            'work' => $work,
            'categories' => $repoCategory->findAll()
        ]);
    }

    /**
     * @Route("/admin/work/{id}/remove", name="work_remove", methods="REMOVE", requirements={"id"="\d+"})
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

    /**
     * Ajoute ou Retire une category dynamiquement
     * 
     * @Route("/admin/work/{work_id}/category/{category_id}/checked", name="work_category_checked", requirements={"id"="\d+"})
     *
     * @param Work $work
     * @param Category $category
     * @param ObjectManager $manager
     * @param CategoryRepository $repoCategory
     * @return Response
     */
    public function checkedCategory(Work $work_id, Category $category_id, ObjectManager $manager, CategoryRepository $repoCategory) : Response
    {

        if ($work_id->getCategories()->contains($category_id)) { // si la category est déjà dans le work

            $category_id->removeWork($work_id);

            $manager->persist($category_id);
            $manager->flush();

            return $this->json([
                'code' => 200, 
                'message' => 'categorie bien supprimé',
            ], 200);
        }

        $category_id->addWork($work_id);

        $manager->persist($category_id);
        $manager->flush();

        return $this->json([
            'code' => 200, 
            'message' => 'categorie bien ajouté'
        ], 200);
    }
}
