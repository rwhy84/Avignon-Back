<?php

namespace App\Controller;

use App\Entity\Etablissement;
use App\Form\EtablissementType;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EtablissementRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EtablissementAdminController extends AbstractController
{
    /**
     * @Route("/etablissement/admin", name="etablissement_show")
     */
    public function index(EtablissementRepository $etablissementRepository, PaginatorInterface $paginatorInterface, Request $request)

    {
    
        $etablissements = $etablissementRepository->findAll();
       

       $etab = $paginatorInterface->paginate(
           $etablissements,
           $request->query->getInt('page', 1), 5
       );

        return $this->render('etablissement_admin/index.html.twig', [
            // 'etablissement' => $etablissements,
            'etablissement' => $etab
        ]);
    }

    /**
     * @Route("/admin/etablissement/delete/{id}", name="etablissement_delete")
     *
     */
    public function delete($id, Etablissement $etablissement, EntityManagerInterface $em)
    {

        $em->remove($etablissement);
        $em->flush();

        return $this->redirectToRoute('etablissement_show');
    }


    /**
     *
     * @Route("/admin/etablissement/edit/{id}", name="etablissement_edit")
     */
    public function edit($id, EtablissementRepository $etablissementRepository, Request $request, EntityManagerInterface $em)
    {


        $etablissement = $etablissementRepository->find($id);


        if (!$etablissement) {
            throw $this->createNotFoundException();
        }


        $form = $this->createForm(EtablissementType::class, $etablissement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('event_show', ['id' => $etablissement->getId()]);
        }

        return $this->render('etablissement_admin/edit.html.twig', [
            'postForm' => $form->createView()
        ]);
    }
}
