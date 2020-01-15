<?php


namespace App\Model\Element;

use App\Model\AbstractManager;

class CaptureManager extends AbstractManager
{
    const TABLE='User';
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectCaptureChanteur($id)
    {
        return $this->pdo->query("
        select chanteursCaptures FROM User WHERE ID=$id")->fetchColumn();
    }

    public function updateCaptureChanteurs(INT $chanteur, INT $id)
    {
        $this->pdo->query("UPDATE User SET chanteursCaptures=chanteursCaptures+$chanteur WHERE ID=$id");
    }
}
