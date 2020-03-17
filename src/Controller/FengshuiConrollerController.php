<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FengshuiConrollerController extends AbstractController
{
    /**
     * @Route("/fengshui", name="fengshui")
     */
    public function fengshui()
    {
        return $this->render('fengshui_conroller/fengshui.html.twig', [
            'controller_name' => 'FengshuiConrollerController',
        ]);
    }

}
