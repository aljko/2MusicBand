<?php

namespace App\Model\Element;

use App\Model\AbstractManager;

class BlogManager extends AbstractManager
{
    const TABLE = 'Modul_Blog';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllWithPhotosConcerts($limit, $pageArticle = 1)
    {
        //$table=self::TABLE;
        $pageArticle=$pageArticle*2-2;
        return $this->pdo->query("
            SELECT Modul_Blog.*, 
            Concerts.*, 
            Photos.*, 
            Modul_Blog.ID AS Modul_Blog_id, 
            Concerts.ID AS Concerts_id, 
            Photos.ID AS Photos_id  
            FROM Modul_Blog
            JOIN Photos ON Photos.ID = Modul_Blog.id_photos
            JOIN Concerts ON Concerts.ID = Modul_Blog.id_concert
            ORDER BY Modul_Blog.ID DESC
            LIMIT $limit OFFSET $pageArticle
            ")->fetchAll();
    }

    public function selectAllArticle($limit, $pageArticle = 1)
    {
        $pageArticle=$pageArticle*2-2;
        return $this->pdo->query("select b.ID as blogID, b.text,
        b.title as blogTitle, c.ville,c.ID as concertID,
        v.path_video,p.path_image from Modul_Blog b 
        join Concerts c on c.ID=b.id_concert 
        join Clip v on v.ID = b.id_clip 
        join Photos p on p.ID = b.id_photos
        ORDER BY blogID DESC LIMIT $limit OFFSET $pageArticle")->fetchAll();
    }
    public function selectAllArticle2($limit, $pageArticle = 1)
    {
        $pageArticle=$pageArticle*2-2;
        return $this->pdo->query("select b.ID as blogID, 
        b.text, b.title as blogTitle, 
        c.ville,c.ID as concertID, v.path_video,p.path_image, 
        b.id_pool_photos from Modul_Blog b 
        left join Concerts c on c.ID=b.id_concert 
        left join Clip v on v.ID = b.id_clip 
        left join Photos p on p.ID = b.id_photos 
        left join Gallery_Name n on n.ID=b.id_pool_photos
        ORDER BY blogID DESC LIMIT $limit OFFSET $pageArticle")->fetchAll();
    }
    public function nbArticle()
    {
        return $this->pdo->query("
            SELECT *
            FROM Modul_Blog
            ")->rowCount();
    }

    public function selectArticleById($id = 1)
    {
        return $this->pdo->query("select b.ID as blogID, 
        b.text, b.title as blogTitle, 
        c.ville,c.ID as concertID, v.path_video,p.path_image, 
        p.ID as photoID,
        b.id_pool_photos from Modul_Blog b 
        left join Concerts c on c.ID=b.id_concert 
        left join Clip v on v.ID = b.id_clip 
        left join Photos p on p.ID = b.id_photos 
        left join Gallery_Name n on n.ID=b.id_pool_photos
        where b.ID=$id")->fetch();
    }

    public function nbPage()
    {
        return ceil(($this->pdo->query("
            SELECT * FROM Modul_Blog ")->rowCount())/2);
    }
}
