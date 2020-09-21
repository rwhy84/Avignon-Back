<?php

namespace App\Controller;

use App\Entity\Etablissement;
use App\Entity\Event;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\EtablissementRepository;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminIndexController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function index(EventRepository $event, EtablissementRepository $etablissements, UserRepository $userRepository, CategoryRepository $categoryRepository, CommentRepository $commentRepository)
    {
        $events = $event->findAll();
        $lastEtablissement = $etablissements->findBy([], ['id' => 'DESC'], 10);
        $etablissements = $etablissements->findAll();
        $users = $userRepository->findAll();
        $categories = $categoryRepository->findAll();
        $lastEvent = $event->findBy([], ['id' => 'DESC'], 10);
        $lastComments = $commentRepository->findBy([], ['id' => 'DESC'], 10);


        return $this->render('admin_index/index.html.twig', [
            'events' => $events,
            'etablissements' => $etablissements,
            'users' => $users,
            'categories' => $categories,
            'lastEvent' => $lastEvent,
            'lastEtablissement' => $lastEtablissement,
            'lastComments' => $lastComments,


        ]);
    }





    // /**
    //  * @Route("admin/etablissement", name="etablissement_show")
    //  */
    // public function show(Etablissement $etablissement)
    // {

    //     return $this->render('admin_index/etablissementshow.html.twig', [
    //         'etablissement' => $etablissement
    //     ]);
    // }

    /**
     * @Route("admin/user", name="event_show")
     */
    // public function show(User $users)
    // {

    //     return $this->render('admin_index/usershow.html.twig', [
    //         'user' => $users
    //     ]);
    // }
}
