<?php

namespace App\Model\Element;

use App\Model\AbstractManager;

class GalleryPhotoManager extends AbstractManager
{

    const TABLE="Gallery_Photo";

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function updateGalleryPhoto(int $galleryID, int $galleryPhotoID)
    {
        var_dump($galleryID, $galleryPhotoID);
        $requete=$this->pdo->prepare("UPDATE Gallery_Photo SET id_gallery_name=:galleryID 
        WHERE ID=:galleryPhotoID");
        $requete->bindValue("galleryID", $galleryID, \PDO::PARAM_INT);
        $requete->bindValue("galleryPhotoID", $galleryPhotoID, \PDO::PARAM_INT);
        $requete->execute();
    }
    public function insert(int $photoID, int $galleryID)
    {
        $requete=$this->pdo->prepare("INSERT INTO Gallery_Photo(id_gallery_name,id_photos)
        VALUES(:galleryID,:photoID)");
        $requete->bindValue("galleryID", $galleryID, \PDO::PARAM_INT);
        $requete->bindValue("photoID", $photoID, \PDO::PARAM_INT);
        $requete->execute();
    }
    public function updateGallery(int $galleryPhotoID, int $galleryNameID)
    {
        $requete=$this->pdo->prepare("UPDATE Gallery_Photo 
        SET id_gallery_name=:galleryNameID WHERE ID=:galleryPhotoID");
        $requete->bindValue("galleryNameID", $galleryNameID, \PDO::PARAM_INT);
        $requete->bindValue("galleryPhotoID", $galleryPhotoID, \PDO::PARAM_INT);
        $requete->execute();
    }
    public function deleteGallery(int $id)
    {
        $requete=$this->pdo->prepare("DELETE FROM Gallery_Photo WHERE id_gallery_name=:ID");
        $requete->execute(array("ID"=>$id));
    }
}
