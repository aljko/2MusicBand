<?php

namespace App\Model\Admin;

use App\Model;

class AdminManager extends Model\AbstractManager
{
    const TABLE = 'Clip';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
