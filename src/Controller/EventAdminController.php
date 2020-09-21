<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventAdminController extends AbstractController
{
    /**
     * @Route("admin/event", name="event_show")
     */
    public function show(EventRepository $event, PaginatorInterface $paginatorInterface, Request $request)
    {

        $event = $event->findAll();


        $events = $paginatorInterface->paginate(
            $event,
            $request->query->getInt('page', 1), 5
        );


        return $this->render('event_admin/index.html.twig', [
            'event' => $events
        ]);
    }



    /**
     *
     * @Route("/event/edit/{id}", name="event_edit")
     */
    public function edit($id, EventRepository $eventRepository, Request $request, EntityManagerInterface $em)
    {


        $event = $eventRepository->find($id);


        if (!$event) {
            throw $this->createNotFoundException();
        }


        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('event_show', ['id' => $event->getId()]);
        }

        return $this->render('event_admin/edit.html.twig', [
            'postForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/event/delete/{id}", name="event_delete")
     *
     */
    public function delete($id, Event $event, EntityManagerInterface $em)
    {

        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('event_show');
    }
}
