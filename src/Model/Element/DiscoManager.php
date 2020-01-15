<?php

namespace App\Model\Element;

use App\Model\AbstractManager;

class DiscoManager extends AbstractManager
{
    const TABLE="Discographie";

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    public function selectByAlbum()
    {
        $temp=[];
        $solution=[];
        $requete=$this->pdo->query("SELECT * FROM Discographie")->fetchAll();
        foreach ($requete as $r) {
            if (empty($temp)) {
                $temp=$r;
                array_push($solution, $r);
            } else {
                if ($temp["cd_title"]!=$r["cd_title"]) {
                    $temp=$r;
                    array_push($solution, $r);
                }
            }
        }
        return $solution;
    }
    public function updateSongTitle($id, $songTitle)
    {
        $requete=$this->pdo->prepare("UPDATE Discographie set song_title=:songTitle WHERE ID=:id");
        $requete->bindValue('songTitle', $songTitle, \PDO::PARAM_STR);
        $requete->bindValue('id', $id, \PDO::PARAM_INT);
        $requete->execute();
    }
}
