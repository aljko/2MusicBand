<?php

namespace App\Controller\Concerts;

use App\Controller\AbstractController;
use App\Model\Element\ConcertsManager;
use App\Model\Element\NavbarManager;
use App\Controller\Map\MapController;

class ConcertsController extends AbstractController
{
    public function index()
    {
        $authority = $_SESSION["authority"];
        $navbarManager = new NavbarManager();
        $navbar = $navbarManager->selectByAuthority($authority);

        $concerts = new ConcertsManager();
        $concertsArray = $concerts->selectAll();

        return $this->twig->render("Concerts/concerts.index.html.twig", ["concerts" => $concertsArray,
            'menus' => $navbar]);
    }
}
