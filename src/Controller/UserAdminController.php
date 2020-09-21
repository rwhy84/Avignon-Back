<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserAdminController extends AbstractController
{
    /**
     * @Route("admin/user", name="user_show")
     */
    public function show(UserRepository $user, PaginatorInterface $paginatorInterface, Request $request)
    {

        $user = $user->findAll();

        $users = $paginatorInterface->paginate(
            $user,
            $request->query->getInt('page', 1), 5
        );

        return $this->render('user_admin/index.html.twig', [
            'user' => $users
        ]);
    }

    /**
     * @Route("/admin/user/{id}", name="user_delete")
     *
     */
    public function delete($id, User $user, EntityManagerInterface $em)
    {

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('user_show');
    }

    /**
     *
     * @Route("/admin/user/edit/{id}", name="user_edit")
     */
    public function edit($id, UserRepository $users, Request $request, EntityManagerInterface $em)
    {


        $event = $users->find($id);


        if (!$users) {
            throw $this->createNotFoundException();
        }


        $form = $this->createForm(UserType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('user_show', ['id' => $users->getId()]);
        }

        return $this->render('user_admin/edit.html.twig', [
            'postForm' => $form->createView()
        ]);
    }
}
