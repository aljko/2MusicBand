<?php

namespace App\Controller\Biographie;

use App\Controller\AbstractController;
use App\Model\Element\NavbarManager;
use App\Model\Element\DiscoManager;
use App\Model\Element\ClipManager;

class BiographieController extends AbstractController
{

    public function index()
    {
        $navbarManager = new NavbarManager;
        $menu = $navbarManager->selectByAuthority($_SESSION['authority']);

        return $this->twig->render('Biographie/Biographie.index.html.twig', ['menus'=>$menu]);
    }
}
