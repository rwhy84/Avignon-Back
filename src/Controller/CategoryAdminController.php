<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryAdminController extends AbstractController
{
    /**
     * @Route("/admin/category", name="category_show")
     */
    public function index(CategoryRepository $cat)
    {

        $category = $cat->findAll();

        return $this->render('category_admin/index.html.twig', [
            'category' => $category,
        ]);
    }


    /**
     *
     * @Route("/admin/category/edit/{id}", name="category_edit")
     */
    public function edit($id, CategoryRepository $cat, Request $request, EntityManagerInterface $em)
    {


        $category = $cat->find($id);



        if (!$category) {
            throw $this->createNotFoundException();
        }


        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('category_show', ['id' => $category->getId()]);
        }

        return $this->render('category_admin/edit.html.twig', [
            'postForm' => $form->createView()
        ]);
    }






    /**
     * @Route("/admin/category/delete/{id}", name="category_delete")
     *
     */
    public function delete($id, Category $cat, EntityManagerInterface $em)
    {

        $em->remove($cat);
        $em->flush();

        return $this->redirectToRoute('category_show');
    }



    /**
     * @Route("/admin/category/create", name="category_create")
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CategoryType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            /** @var \App\Entity\Category */
            $category = $form->getData();



            $em->persist($category);
            $em->flush();



            return $this->redirectToRoute('category_show', ['id' => $category->getId()]);
        }

        $view = $form->createView();

        return $this->render('category_admin/create.html.twig', [
            'postForm' => $view
        ]);
    }
}
