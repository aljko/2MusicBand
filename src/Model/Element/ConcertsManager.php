<?php
// NOTE code de Guillaume

namespace App\Model\Element;

use App\Model\AbstractManager;

class ConcertsManager extends AbstractManager
{
    const TABLE = 'Concerts';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectByVille(string $ville)
    {
        return $this->pdo->query("SELECT * FROM Concerts WHERE ville='{$ville}'");
    }
} //fin code de Guillaume
