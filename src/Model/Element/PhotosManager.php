<?php

namespace App\Model\Element;

use App\Model\AbstractManager;

class PhotosManager extends AbstractManager
{
    const TABLE = "Photos";

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function validerPhoto(int $id)
    {
        $photo = self::TABLE;
        $validerPhoto = $this->pdo->prepare("UPDATE $photo set valid=1 WHERE ID=:id");
        $validerPhoto->bindValue("id", $id, \PDO::PARAM_INT);
        $validerPhoto->execute();
    }

    public function supprimerPhoto($id)
    {
        $photo = self::TABLE;
        $supprimerPhoto = $this->pdo->prepare("DELETE FROM Modul_Blog WHERE id_photos=:id_photos");
        $supprimerPhoto->bindValue("id_photos", $id, \PDO::PARAM_INT);
        $supprimerPhoto->execute();
        $supprimerPhoto = $this->pdo->prepare("DELETE FROM Gallery_Photo WHERE id_photos=:id_photos");
        $supprimerPhoto->bindValue("id_photos", $id, \PDO::PARAM_INT);
        $supprimerPhoto->execute();
        $supprimerPhoto = $this->pdo->prepare("DELETE FROM $photo WHERE ID=:id");
        $supprimerPhoto->bindValue("id", $id, \PDO::PARAM_INT);
        $supprimerPhoto->execute();
    }
}
