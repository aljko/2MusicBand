<?php

namespace App\Model\Element;

use App\Model\AbstractManager;

class ClipManager extends AbstractManager
{
    const TABLE="Clip";

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectLast()
    {
        return $this->pdo->query("select * from Clip order by date_upload DESC limit 1")->fetch();
    }
}
