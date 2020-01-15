<?php

namespace App\Model\Element;

use App\Model\AbstractManager;

class NavbarManager extends AbstractManager
{
    const TABLE = 'Menu';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectByAuthority(string $authority): array
    {
        $menu = self::TABLE;
        return $this->pdo->query("SELECT * FROM $menu WHERE authority LIKE 
        '%{$authority}%' ORDER BY position")->fetchAll();
    }
}
