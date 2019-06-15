<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/category/list", name="category_list")
     * @Route("/admin/category/{id}/edit", name="category_edit")
     * 
     * @param Category $category est Null quand on est sur "category_list"
     * @param CategoryRepository $repo pour afficher findAll();
     * @param Request $request
     * @param ObjectManager $manager
     * @return void
     */
    public function listFormCategory(Category $category = null, CategoryRepository $repo, Request $request, ObjectManager $manager)
    {
        if(!$category) {
            $category = new Category();
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();
            
            $this->addFlash('success', 'La catégorie à bien été enregistré');

            return $this->redirectToRoute('category_list');
        }

        $categories = $repo->findAll();

        return $this->render('category/list.html.twig', [
            'formCategory' => $form->createView(),
            'editCategory' => $category->getId() !== null,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/category/{id}/remove", name="category_remove")
     *
     * @param Category $category
     * @param ObjectManager $manager
     * @param Request $request
     * @return void
     */
    public function removeCategory(Category $category, ObjectManager $manager, Request $request)
    {
        $submittedToken = $request->request->get('_token');
        $categoryId = $category->getId();

        if($this->isCsrfTokenValid('remove-category' . $categoryId, $submittedToken)) {
            $manager->remove($category);
            $manager->flush();
            
            $this->addFlash('success', 'La catégorie à bien été supprimé');
        }
        return $this->redirectToRoute('category_list');
    }
}
