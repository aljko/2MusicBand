<?php
namespace App\Model\Element;

use App\Model\AbstractManager;

class CommentsManager extends AbstractManager
{
    const TABLE = "Commentaire";
    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectCommentByPhoto()
    {
        return $this->pdo->query("
        select c.id_photo, c.ID as cID, 
        p.ID as pID,p.path_image,p.name,
        c.text, u.ID as uID,u.pseudo,
        c.valid from Commentaire c 
        join Photos p on p.ID=c.id_photo 
        join User u on u.ID =c.id_user 
        where c.valid=1")->fetchAll();
    }
    public function insertCommentPhoto($id, $comment, $title, $userId)
    {
        $requete=$this->pdo->prepare("INSERT INTO Commentaire
        (title,text,id_photo,valid,id_user)
        VALUES(:title,:text,:id_photo,:valid,:id_user)");
        $requete->bindValue('title', $title, \PDO::PARAM_STR);
        $requete->bindValue('text', $comment, \PDO::PARAM_STR);
        $requete->bindValue('id_photo', $id, \PDO::PARAM_INT);
        $requete->bindValue('valid', 0, \PDO::PARAM_INT);
        $requete->bindValue('id_user', $userId, \PDO::PARAM_INT);
        $requete->execute();
    }
    public function validerComment(int $id)
    {
        $requete=$this->pdo->prepare("UPDATE Commentaire SET valid=1  WHERE ID='{$id}'");
        $requete->execute();
    }
    public function supprimerComment($id)
    {
        $requete=$this->pdo->prepare("DELETE FROM Commentaire WHERE ID= :id ");
        $requete->bindValue("id", $id, \PDO::PARAM_INT);
        $requete->execute();
    }
}
