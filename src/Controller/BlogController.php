<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/admin/blog", name="blog_show")
     */
    public function index(BlogRepository $blog)
    {

        $article = $blog->findAll();

        return $this->render('blog/index.html.twig', [
            'article' => $article,
        ]);
    }


    /**
     * @Route("/admin/blog/delete/{id}", name="blog_delete")
     *
     */
    public function delete($id, Blog $blog, EntityManagerInterface $em)
    {

        $em->remove($blog);
        $em->flush();

        return $this->redirectToRoute('blog_show');
    }


    /**
     * @Route("/admin/blog/create", name="blog_create")
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(BlogType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            /** @var \App\Entity\Blog */
            $article = $form->getData();



            $em->persist($article);
            $em->flush();



            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }

        $view = $form->createView();

        return $this->render('blog/create.html.twig', [
            'postForm' => $view
        ]);
    }



    /**
     *
     * @Route("/admin/blog/edit/{id}", name="blog_edit")
     */
    public function edit($id, BlogRepository $cat, Request $request, EntityManagerInterface $em)
    {


        $category = $cat->find($id);


        if (!$category) {
            throw $this->createNotFoundException();
        }


        $form = $this->createForm(BlogType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('blog_show', ['id' => $category->getId()]);
        }

        return $this->render('blog/edit.html.twig', [
            'postForm' => $form->createView()
        ]);
    }

}
