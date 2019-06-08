<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Form\CategoryType;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/list", name="category_list")
     * @Route("/category/{id}/edit", name="category_edit")
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
        }

        $categories = $repo->findAll();

        return $this->render('category/list.html.twig', [
            'formCategory' => $form->createView(),
            'editCategory' => $category->getId() !== null,
            'categories' => $categories
        ]);
    }
}
