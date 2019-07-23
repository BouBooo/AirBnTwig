<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/bookings", name="admin_bookings_index")
     */
    public function index(BookingRepository $repo)
    {
        $bookings = $repo->findAll();

        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $bookings
        ]);
    }

    /**
     * @Route("/admin/bookings/{id}/edit", name="admin_bookings_edit")
     */
    public function edit(Booking $booking, Request $request, ObjectManager $manager) {
        $form = $this->createForm(AdminBookingType::class, $booking, [
            'validation_groups' => ["front"]
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $booking->setAmount(0);

            $manager->persist($booking);
            $manager->flush();

            $this->addFlash('success', 'Réservation modifiée avec succès');
            return $this->redirectToRoute('admin_bookings_index');
        }
        return $this->render('admin/booking/edit.html.twig', [
            'form' => $form->createView(),
            'booking' => $booking
        ]);
    }

    /**
     * @Route("/admin/bookings/{id}/delete", name="admin_bookings_delete")
     */
    public function delete(Booking $booking, ObjectManager $manager) {
        $manager->remove($booking);
        $manager->flush();

        $this->addFlash('success', 'Réservation supprimée avec succès');
        return $this->redirectToRoute('admin_bookings_index');
    }
}
