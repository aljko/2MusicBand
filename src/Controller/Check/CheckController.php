<?php

namespace App\Controller\Check;

use App\Controller\AbstractController;
use App\Model\Element\CommentsManager;
use App\Model\Element\GalleryPhotoManager;

class CheckController extends AbstractController
{
    public function checkAll()
    {
        if (isset($_POST["galleryID"])) {
            $this->checkChangeGallery();
        }
    }
    public function checkChangeGallery()
    {
            $gallerPhotoManager = new GalleryPhotoManager();
            $gallerPhotoManager->updateGalleryPhoto(
                (int) htmlspecialchars($_POST["galleryID"]),
                (int) htmlspecialchars($_POST["galleryPhotoID"])
            );
            var_dump($_POST);
            //header("Location: /Admin/gallery");
    }

    public function checkCommentaireFromHome()
    {

        if (empty($_POST["comment"])) {
            $_SESSION["comment"] = "pas de commentaire";
            header("location: /");
        } else {
            $commentManager = new CommentsManager();
            $commentManager->insertCommentPhoto(
                htmlspecialchars($_POST["photoID"]),
                htmlspecialchars($_POST["comment"]),
                htmlspecialchars($_POST["photoTitle"]),
                htmlspecialchars($_SESSION["userId"])
            );
            unset($_SESSION["comment"]);
            header("Location: /");
        }
    }
}
