<?php

namespace App\Model\Element;

use App\Model\AbstractManager;

class GalleryNameManager extends AbstractManager
{
    const TABLE = "Gallery_Name";

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllFromAll()
    {
        return $this->pdo->query("select n.name ,i.path_image, 
        g.ID as galleryID, n.ID as nameID, i.ID as photoID 
        from Gallery_Photo g join Gallery_Name n on g.id_gallery_name=n.ID 
        join Photos i on g.id_photos=i.ID order by n.name")->fetchAll();
    }

    public function updateName(int $id, string $name)
    {
        $isTrue = true;
        $galleryNameManager = new GalleryNameManager();
        $gallerys = $galleryNameManager->selectAll();
        foreach ($gallerys as $gallery) {
            if ($gallery["name"] == $name) {
                $isTrue = false;
            }
        }
        if ($name==""||$name==null) {
            $isTrue=false;
        }
        if ($isTrue) {
            $requete = $this->pdo->prepare("UPDATE Gallery_Name set name=:name WHERE ID=:id");
            $requete->bindValue("name", $name, \PDO::PARAM_STR);
            $requete->bindValue("id", $id, \PDO::PARAM_INT);
            $requete->execute();
            $_SESSION["errorsGallery"] = "";
            header("Location: /Admin/gallery");
        } else {
            $_SESSION["errorsGallery"] = "gallery alredy exist";
            header("Location: /Admin/gallery");
        }
    }
    public function insertName(string $name)
    {

        $isTrue = true;
        $galleryNameManager = new GalleryNameManager();
        $gallerys = $galleryNameManager->selectAll();
        foreach ($gallerys as $gallery) {
            if ($gallery["name"] == $name) {
                $isTrue = false;
            }
        }
        if ($isTrue) {
            var_dump($_POST);
            $requete = $this->pdo->prepare("INSERT INTO Gallery_Name(name)VALUE(:name)");
            $requete->bindValue("name", $name, \PDO::PARAM_STR);
            $requete->execute();
            $_SESSION["errorsGallery"] = "";
            header("Location: /Admin/gallery");
        } else {
            $_SESSION["errorsGallery"] = "gallery alredy exist";
            header("Location: /Admin/gallery");
        }
    }
    public function deleteGalleryName(int $id)
    {
        var_dump($id);

        $galleryPhotoManager=new GalleryPhotoManager();
        $galleryPhotoManager->deleteGallery($id);
        $requete = $this->pdo->prepare("DELETE FROM Gallery_Name WHERE id=:id");
        $requete->bindValue("id", $id, \PDO::PARAM_INT);
        $requete->execute();
        header("Location: /Admin/gallery");
    }
}
