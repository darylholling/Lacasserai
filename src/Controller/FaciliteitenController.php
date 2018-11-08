<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FaciliteitenController extends AbstractController
{
    /**
     * @Route("/faciliteiten", name="faciliteiten")
     */
    public function index()
    {
        return $this->render('faciliteiten/index.html.twig', [
            'controller_name' => 'FaciliteitenController',
        ]);
    }
}
