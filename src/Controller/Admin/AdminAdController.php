<?php

namespace App\Controller\Admin;

use App\Repository\AdRepository;
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
}
