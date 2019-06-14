<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo) {
        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Create an ad
     * 
     * @Route("/ads/new", name="ads_create")
     */
    //
    public function create(Request $request, ObjectManager $manager) {
        $ad = new Ad();

        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        $ad->setCoverImage('http://placehold.it/60x60');
        $ad->setAuthor($this->getUser());

        if($form->isSubmitted() && $form->isValid()) {
            foreach($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success', "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !");


            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }
        

        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * Show specific ad
     *
     * @Route("/ads/{slug}", name="ads_show")
     */
    public function show(Ad $ad) {
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }

    /**
     * @Route("/ads/{slug}/edit", name="ads_edit")
     */
    public function edit(Ad $ad, Request $request, ObjectManager $manager) {
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            foreach($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success', "L'annonce <strong>{$ad->getTitle()}</strong> a bien été modifiée !");


            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ad/edit.html.twig', [
            'form' => $form->createView(),
            'ad' => $ad
        ]);
    }



}