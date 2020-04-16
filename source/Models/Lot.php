<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class Lot extends DataLayer
{
    public function __construct()
    {
        parent::__construct("lots", [], '', true);
    }
}