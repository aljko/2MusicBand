<?php

namespace App\Controller\GalleryName;

use App\Controller\AbstractController;
use App\Model\Element\GalleryNameManager;
use App\Model\Element\GalleryPhotoManager;
use App\Model\Element\PhotosManager;

class GalleryNameController extends AbstractController
{

    public function doRoute()
    {
        $doGalleryPhoto=new GalleryPhotoManager();
        $doGallery=new GalleryNameManager();
        $doPhoto=new PhotosManager();
        if (isset($_POST["createGalleryName"])) {
            $doGallery->insertName(htmlspecialchars($_POST["createGalleryName"]));
        }
        if (isset($_POST["gSup"])) {
            var_dump($_POST);
            $doGallery->deleteGalleryName((int)htmlspecialchars($_POST["galleryID"]));
        }
        if (isset($_POST["gMod"])) {
            var_dump($_POST);
            $doGallery->updateName((int)htmlspecialchars($_POST["galleryID"]), htmlspecialchars($_POST["galleryName"]));
        }
        if (isset($_POST["gpMod"])) {
            $doGalleryPhoto->updateGallery(
                (int)htmlspecialchars($_POST["galleryPhotoID"]),
                (int)htmlspecialchars($_POST["galleryNameID"])
            );
            header("Location: /Admin/gallery");
        }
        if (isset($_POST["gpSup"])) {
            $doPhoto->supprimerPhoto((int)htmlspecialchars($_POST["photoID"]));
            header("Location: /Admin/gallery");
        }
    }
}
