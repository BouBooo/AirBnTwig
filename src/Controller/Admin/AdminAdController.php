<?php

namespace App\Controller\Admin;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdController extends AbstractController
{
    /**
     * @Route("/admin/ads", name="admin_ads_index")
     */
    public function index(AdRepository $ads)
    {

        return $this->render('admin/ad/index.html.twig', [
            'ads' => $ads->findAll()
        ]);
    }

    /**
     * @Route("/admin/ads/{id}/edit", name="admin_ads_edit")
     */
    public function edit(Ad $ad, Request $request, ObjectManager $manager) {
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success', 'Annonce modifié avec succès');
        }

        return $this->render('admin/ad/edit.html.twig', [
            'ad' => $ad,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/ads/{id}/delete", name="admin_ads_delete")
     */
    public function delete(Ad $ad, ObjectManager $manager) {
        $haveActiveBookings = count($ad->getBookings());

        if($haveActiveBookings > 0) {
            $this->addFlash('warning', 'Impossible de supprimer une annonce avec une ou plusieurs réservation(s) active(s)');
        }
        else {
            $manager->remove($ad);
            $manager->flush();
    
            $this->addFlash('success', 'L\'annonce <em>' . $ad->getTitle() . '</em> a bien été supprimée');
        }

        return $this->redirectToRoute('admin_ads_index');
    }
}
