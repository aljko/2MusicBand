<?php

namespace App\Controller\Admin;

use App\Controller;
use App\Model\Admin\AdminManager;
use App\Model\Element\BlogManager;
use App\Model\Element\CommentsManager;
use App\Model\Element\NavbarManager;
use App\Model\Element\GalleryPhotoManager;
use App\Model\Element\PhotosManager;
use App\Model\Element\GalleryNameManager;

class AdminController extends Controller\AbstractController
{

    public function index()
    {
        if ('X' !=  $_SESSION["authority"]) {
            header("Location: /");
        } else {
            $navbarManager = new NavbarManager;
            $menus = $navbarManager->selectByAuthority($_SESSION["authority"]);

            $photosManager = new PhotosManager;
            $photos = $photosManager->selectByValid();

            $blogManager = new BlogManager;
            $blogs = $blogManager->selectAllWithPhotosConcerts(1, 1);

            $commentsManager = new CommentsManager;
            $comments = $commentsManager->selectByValid();


            //var_dump($_SESSION["authority"]);
            //var_dump($comments,$blogs,$photos);
            return $this->twig->render('Admin/indexAdmin.html.twig', [
                "menus" => $menus,
                "photos" => $photos,
                "blogs" => $blogs,
                "comments" => $comments
            ]);
        }
    }
    public function gallery()
    {
        $errors=[];
        if (!isset($_SESSION["errorsGallery"])) {
            $_SESSION["errorsGallery"]="";
        } else {
            $errors=$_SESSION["errorsGallery"];
        }

        if ('X' !=  $_SESSION["authority"]) {
            header("Location: /");
        } else {
            if (isset($_POST["gallery"])) {
                $defaultGallery = $_POST["gallery"];
            } else {
                $defaultGallery = 1;
            }
            $navbarManager = new NavbarManager;
            $menus = $navbarManager->selectByAuthority($_SESSION["authority"]);

            $gallerNameManager = new GalleryNameManager();
            $galleryName = $gallerNameManager->selectAllFromAll();
            $gallerys=$gallerNameManager->selectAll();
            return $this->twig->render('Admin/gallery.html.twig', [
                "menus" => $menus,
                "galleryName" => $galleryName,
                "defaultGallery" => $defaultGallery,
                "gallerys"=>$gallerys,
                "errors"=>$errors
            ]);
        }
    }
    public function validerModerationPhoto($id)
    {
        if ('X' == $_SESSION["authority"]) {
            $photosManager = new PhotosManager();
            $photosManager->validerPhoto($id);
            header("Location: /Admin/index");
        } else {
            header("Location: /Home/index");
        }
    }

    public function supprimerModerationPhoto($id)
    {
        if ('X' == $_SESSION["authority"]) {
            $photosManager = new PhotosManager();
            $photosManager->supprimerPhoto($id);
            header("Location: /Admin/index");
        } else {
            header("Location: /Home/index");
        }
    }

    public function validerModerationComment($id)
    {
        if ('X' == $_SESSION["authority"]) {
            $commentsManager = new CommentsManager();
            $commentsManager->validerComment((int)$id);
            header("Location: /Admin/index");
        } else {
            header("Location: /Home/index");
        }
    }
    public function supprimerModerationComment($id)
    {
        if ('X' == $_SESSION["authority"]) {
            $commentsManager = new CommentsManager();
            $commentsManager->supprimerComment((int)$id);
            header("Location: /Admin/index");
        } else {
            header("Location: /Home/index");
        }
    }
}
