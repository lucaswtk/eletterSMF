<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class Field extends DataLayer
{
    public function __construct()
    {
        parent::__construct("fields", ["model_id", "metadata_id"], 'id', false);
    }
}