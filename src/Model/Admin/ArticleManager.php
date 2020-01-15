<?php

namespace App\Model\Admin;

use App\Model\Admin;
use App\Model\AbstractManager;

class ArticleManager extends AbstractManager
{
    const TABLE = 'Modul_Blog';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllWithPhotosAndClipsAndConcerts()
    {
        $table = self::TABLE;
        return $this->pdo->query("SELECT * FROM $table b JOIN Photos p JOIN Clip cl 
        JOIN Concerts conc ON p.ID = b.id_photos and cl.ID = b.id_photos 
        and conc.ID = b.id_photos")->fetchAll();
    }

    public function insertArticle(string $titre, string $comment)
    {
        $stInsertArt = $this->pdo->prepare("INSERT INTO Modul_Blog (title, text) VALUES (:titre, :comment)");
        $stInsertArt->bindValue('titre', $titre, \PDO::PARAM_STR);
        $stInsertArt->bindValue('comment', $comment, \PDO::PARAM_STR);
        $stInsertArt->execute();
        $_SESSION["lastInsertId"] = $this->pdo->lastInsertId();
    }

    public function updateArticleConcert(int $id, int $idConcert)
    {
        $stUpdateACo = $this->pdo->prepare("UPDATE Modul_Blog SET id_concert = :id_concert WHERE ID = :ID");
        $stUpdateACo->bindValue('id_concert', $idConcert, \PDO::PARAM_INT);
        $stUpdateACo->bindValue('ID', $id, \PDO::PARAM_INT);
        $stUpdateACo->execute();
    }

    public function updateArticleClip(int $id, int $idClip)
    {
        $stUpdateACl = $this->pdo->prepare("UPDATE Modul_Blog SET id_clip = :id_clip WHERE ID = :ID");
        $stUpdateACl->bindValue('id_clip', $idClip, \PDO::PARAM_INT);
        $stUpdateACl->bindValue('ID', $id, \PDO::PARAM_INT);
        $stUpdateACl->execute();
    }

    public function updateArticlePhotos(int $id, int $idPhotos)
    {
        $stUpdateAP = $this->pdo->prepare("UPDATE Modul_Blog SET id_photos = :id_photos WHERE ID = :ID");
        $stUpdateAP->bindValue('id_photos', $idPhotos, \PDO::PARAM_INT);
        $stUpdateAP->bindValue('ID', $id, \PDO::PARAM_INT);
        $stUpdateAP->execute();
    }
    public function updateArticleGallery(int $id, int $idGallery)
    {
        $stUpdateAG = $this->pdo->prepare("UPDATE Modul_Blog SET id_pool_photos = :id_gallery WHERE ID = :ID");
        $stUpdateAG->bindValue('id_gallery', $idGallery, \PDO::PARAM_INT);
        $stUpdateAG->bindValue('ID', $id, \PDO::PARAM_INT);
        $stUpdateAG->execute();
    }
    public function updateArticle(
        string $titre,
        string $text,
        int $idConcert,
        int $idClip,
        int $idPhotos,
        int $idPoolPhotos,
        int $id
    ) {
          
        $stUpdateA = $this->pdo->prepare("UPDATE Modul_Blog SET title = :title, text = :text,
        id_concert = :id_concert, id_clip = :id_clip, id_photos = :id_photos, 
        id_pool_photos = :id_pool_photos WHERE ID = :id");
        $stUpdateA->bindValue('title', $titre, \PDO::PARAM_STR);
        $stUpdateA->bindValue('text', $text, \PDO::PARAM_STR);
        $stUpdateA->bindValue('id_concert', $idConcert, \PDO::PARAM_INT);
        $stUpdateA->bindValue('id_clip', $idClip, \PDO::PARAM_INT);
        $stUpdateA->bindValue('id_photos', $idPhotos, \PDO::PARAM_INT);
        $stUpdateA->bindValue('id_pool_photos', $idPoolPhotos, \PDO::PARAM_INT);
        $stUpdateA->bindValue('id', $id, \PDO::PARAM_INT);
        $stUpdateA->execute();
    }

    public function deleteArticle(int $id)
    {
        $stDeleteA = $this->pdo->prepare("DELETE FROM Modul_Blog WHERE ID = :ID");
        $stDeleteA->bindValue('ID', $id, \PDO::PARAM_INT);
        $stDeleteA->execute();
    }

    public function listArticle()
    {
        return $this->pdo->query("SELECT b.ID as blogID, 
        b.title, b.text, c.ID as concertID, c.title as concert, 
        v.ID as clipID, v.name as clip, p.ID as photoID, 
        p.name as photo, g.ID as gallery
        from Modul_Blog b 
        join Concerts c on c.ID=b.id_concert 
        join Clip v on v.ID = b.id_clip 
        join Photos p on p.ID= b.id_photos 
        left join Gallery_Photo g on g.ID = b.id_pool_photos ORDER BY b.title")->fetchAll();
    }
}
