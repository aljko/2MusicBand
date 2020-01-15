<?php

namespace App\Controller\Disco;

use App\Controller\AbstractController;
use App\Model\Element\NavbarManager;
use App\Model\Element\DiscoManager;
use App\Model\Element\ClipManager;

class DiscoController extends AbstractController
{
    public $manager;

    public function __construct()
    {
        parent::__construct();
        $this->manager = new DiscoManager();
    }

    public function index()
    {
        $this->doManager();
        if ('X' === $_SESSION["authority"]) {
            header("Location: /Disco/indexUser");
        } else {
            header("Location: /Disco/indexUser");
        }
    }
    public function doManager()
    {
        $navbarManager = new NavbarManager();
        $_SESSION["menus"] = $navbarManager->selectByAuthority($_SESSION["authority"]);

        $clipManager = new ClipManager();
        $_SESSION["clips"] = [];
        array_push(
            $_SESSION["clips"],
            $clipManager->selectOneById(2),
            $clipManager->selectOneById(3),
            $clipManager->selectOneById(4)
        );
        $_SESSION["discos"] = $this->manager->selectByAlbum();
        $_SESSION["discoSongs"] = $this->manager->selectAll();
    }
    public function indexUser()
    {
        $this->doManager();

        return $this->twig->render("Disco/index.html.twig", [
            "menus" => $_SESSION["menus"],
            "discos" => $_SESSION["discos"],
            "clips" => $_SESSION["clips"],
            "discoSongs" => $_SESSION["discoSongs"]
        ]);
    }
    public function indexAdmin()
    {
        $this->doManager();
        $id=0;
        $songTitle="";
        if (isset($_POST["id"])&&isset($_POST["songTitle"])) {
            $id=$_POST["id"];
            $songTitle=$_POST["songTitle"];
            $_POST = array();
        }
        //var_dump($id, $songTitle,$_POST["id"],$_POST["songTitle"]);
        if (0 != $id) {
            $this->manager->updateSongTitle($id, $songTitle);
        }
            $this->doManager();
            return $this->twig->render("Admin/disco.html.twig", [
            "menus" => $_SESSION["menus"],
            "discos" => $_SESSION["discos"],
            "clips" => $_SESSION["clips"],
            "discoSongs" => $_SESSION["discoSongs"]
            ]);
    }
}
